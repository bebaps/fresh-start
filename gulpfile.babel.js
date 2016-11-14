'use strict';

const LOCALURL = 'freshstart:8888'; // See https://browsersync.io/docs/options/#option-proxy
const PROJECT = 'fresh-start'; // Give this project a name
const PATHS = new function() {
    this.root = './',
    this.assets = `${this.root}assets`,
    this.css = `${this.assets}/css`,
    this.js = `${this.assets}/js`,
    this.fonts = `${this.assets}/fonts`,
    this.images = `${this.assets}/images`,
    this.sass = `${this.assets}/sass`;
};
const SOURCES = {
    php: [
        `${PATHS.root}*.php`,
        `${PATHS.root}**/*.php`
    ],
    html: [ // Rare, but there in certain situations
        `${PATHS.root}*.html`,
        `${PATHS.root}**/*.html`
    ],
    css: [
        `${PATHS.css}/*.css`,
        `!${PATHS.css}/*.min.css`
    ],
    sass: [
        `${PATHS.sass}/**/*.scss`
    ],
    js: [
        `${PATHS.js}/custom/custom.js`
    ],
    images: [
        `${PATHS.images}/**/*.{jpg,png,gif,svg}`
    ],
    concat: [ // Set the order for JS concatenation
        './node_modules/jquery/dist/jquery.js',
        `${PATHS.js}/vendor/*.js`,
        `${PATHS.js}/plugins/*.js`,
        `${PATHS.js}/custom/skip-link-focus-fix.js`,
        `${PATHS.js}/custom/navigation.js`,
        // `${PATHS.js}/custom/customizer.js`,
        `${PATHS.js}/custom/custom.js`,
        `!${PATHS.js}/${PROJECT}.js`
    ]
};
const OPTIONS = { // Set options for the Gulp plugins
    sass: {
        outputStyle: 'expanded',
        includePaths: [
            './node_modules/normalize-scss/sass/'
        ]
    },
    autoprefixer: {
        browsers: [
            '> 1%',
            'last 3 versions',
            'Safari > 7'
        ]
    },
    browsersync: {
        proxy: LOCALURL,
        ghostMode: {
            clicks: true,
            forms: true,
            scroll: false
        },
        browser: [
            'google chrome'
        ],
        reloadOnRestart: true,
        injectChanges: true
    },
    cssnano: {
        autoprefixer: false,
        calc: {
            mediaQueries: true
        },
        colormin: false,
        convertValues: {
            precision: 0
        },
        discardComments: {
            removeAll: true
        },
        discardUnused: false,
        mergeIdents: false,
        reduceIdents: false,
        svgo: {
            encode: true
        },
        zindex: false
    },
    loadplugins: {
        lazy: true
    },
    stylelint: {
        reporters: [{
            formatter: 'string',
            console: true
        }]
    }
};

// Include gulp and plugins
import gulp from 'gulp';
import del from 'del';
import postscss from 'postcss-scss';
import reporter from 'postcss-reporter';

const BROWSERSYNC = require('browser-sync').create();
const $ = require('gulp-load-plugins')(OPTIONS.loadplugins);

/* -------------------------------------------------------------------------------------------------
  # Utility Tasks
------------------------------------------------------------------------------------------------- */
// Delete the contents of the CSS folder, except any prior minified files
gulp.task('clean:css', () => {
    del([
        `${PATHS.css}/${PROJECT}.css`,
        `${PATHS.css}/${PROJECT}.css.map`
    ]);
});

// Delete the generated project JS file
gulp.task('clean:js', () => {
    del([
        `${PATHS.js}/${PROJECT}.*.*`,
        `${PATHS.js}/${PROJECT}.*`
    ]);
});

/* -------------------------------------------------------------------------------------------------
  # Server Tasks
------------------------------------------------------------------------------------------------- */
// Launch a development server
gulp.task('server', () => {
    if (!BROWSERSYNC.active) {
        BROWSERSYNC.init(OPTIONS.browsersync);
    }
});

/* -------------------------------------------------------------------------------------------------
  # Sass/CSS Tasks
------------------------------------------------------------------------------------------------- */
// Lint Sass/CSS
gulp.task('lint:sass', () => {
    return gulp
        .src(SOURCES.sass)
        .pipe($.plumber())
        .pipe($.stylelint(OPTIONS.stylelint));
});

// Compile Sass
gulp.task('sass', ['clean:css'], () => {
    return gulp
        .src(SOURCES.sass)
        .pipe($.sourcemaps.init())
        .pipe($.plumber())
        .pipe($.sass(OPTIONS.sass)
        .on('error', $.sass.logError))
        .on('error', $.notify.onError('Error compiling Sass!'))
        .pipe($.autoprefixer(OPTIONS.autoprefixer))
        // .pipe($.rename({
        //     basename: PROJECT,
        //     extname: '.css'
        // }))
        .pipe($.sourcemaps.write('/'))
        .pipe($.plumber.stop())
        .pipe(gulp.dest(PATHS.css))
        .pipe(BROWSERSYNC.stream());
});

// Minify CSS - Not needed if you will use a plug-in that will minify CSS
gulp.task('minify:css', () => {
    return gulp
        .src(`${PATHS.css}/${PROJECT}.css`)
        .pipe($.plumber())
        .pipe($.cssnano(OPTIONS.cssnano))
        .pipe($.rename({
            basename: PROJECT,
            suffix: '.min',
            extname: '.css'
        }))
        .pipe(gulp.dest(PATHS.css))
        .pipe(BROWSERSYNC.stream());
});

/* -------------------------------------------------------------------------------------------------
  # JS Tasks
------------------------------------------------------------------------------------------------- */
// Lint JavaScript
gulp.task('lint:js', () => {
    return gulp
        .src('./assets/js/custom/*.js')
        .pipe($.plumber())
        // .pipe($.babel())
        .pipe($.eslint())
        .pipe($.eslint.format())
        .pipe($.eslint.failAfterError());
});

// Concatenate JavaScript
gulp.task('js', () => {
    return gulp
        .src(SOURCES.concat)
        .pipe($.sourcemaps.init())
        .pipe($.plumber())
        // .pipe($.babel())
        .pipe($.print())
        .pipe($.concat(`${PROJECT}.js`))
        .pipe($.sourcemaps.write('/'))
        .pipe($.plumber.stop())
        .pipe(gulp.dest(PATHS.js));
});

// Minify JavaScript - Not needed if you will use a plug-in that will minify JS
gulp.task('minify:js', () => {
    return gulp
        .src(`${PATHS.js}/${PROJECT}.js`)
        .pipe($.plumber())
        .pipe($.uglify())
        .pipe($.rename({
            basename: PROJECT,
            suffix: '.min',
            extname: '.js'
        }))
        .pipe($.plumber.stop())
        .pipe(gulp.dest(PATHS.js))
        .pipe(BROWSERSYNC.stream());
});

/* -------------------------------------------------------------------------------------------------
  # Image Tasks
------------------------------------------------------------------------------------------------- */
// Optimize images
gulp.task('minify:images', () => {
    return gulp
        .src(SOURCES.images)
        .pipe($.plumber())
        .pipe($.imagemin({
            interlaced: true,
            progressive: true
        }))
        .pipe($.print())
        .pipe(gulp.dest(PATHS.images));
});

/* -------------------------------------------------------------------------------------------------
  # Packaging Tasks
------------------------------------------------------------------------------------------------- */
// Package a zip for theme upload
gulp.task('package', () => {
  return gulp
    .src([
        `${PATHS.root}**/*`,
        `!${PATHS.root}node_modules`,
        `!${PATHS.root}node_modules/**/*`,
    ])
    .pipe($.zip(`${PROJECT}.zip`))
    .pipe(gulp.dest(PATHS.root));
});

// Build task to run all tasks and and package for distribution
gulp.task('zip', ['sass', 'js', 'minify:images', 'package']);

/* -------------------------------------------------------------------------------------------------
  # Defaults
------------------------------------------------------------------------------------------------- */
// Default task
gulp.task('default', ['sass', 'js', 'server', 'watch']);

// Watch files for changes
gulp.task('watch', () => {
  gulp.watch(SOURCES.sass, ['sass']);
  gulp.watch(SOURCES.js, ['js']);
  gulp.watch(SOURCES.php, BROWSERSYNC.reload);
  gulp.watch(SOURCES.html, BROWSERSYNC.reload);
});
