'use strict';

// Define the local URL used for development
// See https://browsersync.io/docs/options/#option-proxy
const LOCALURL = 'freshstart:8888';

// Give this project a name, used for the build folder
const PROJECT = 'freshstart';

// Define the paths to be used
const PATHS = new function() {
  this.root = './',
  this.dist = `${this.root}_dist/`,
  this.assets = `${this.root}assets`,
  this.css = `${this.assets}/css`,
  this.js = `${this.assets}/js`,
  this.fonts = `${this.assets}/fonts`,
  this.images = `${this.assets}/images`,
  this.sass = `${this.assets}/sass`;
};

// Define the source locations to be used
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
    `${PATHS.js}/theme/custom.js`
  ],
  images: [
    `${PATHS.images}/**/*.{jpg,png,gif,svg}`
  ],
  concat: [ // Set the order for JS concatenation
    './node_modules/jquery/dist/jquery.js',
    `${PATHS.js}/vendor/*.js`,
    `${PATHS.js}/theme/skip-link-focus-fix.js`,
    `${PATHS.js}/theme/custom.js`
  ]
};

// Set options for the Gulp plugins
const OPTIONS = {
  sass: {
    outputStyle: 'expanded'
  },
  autoprefixer: {
    browsers: [
      '> 1%', 'last 3 versions', 'Safari > 7', 'IE > 10'
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
  imagemin: {
    interlaced: true,
    progressive: true
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

// Include gulp and plugins not targeted by gulp-load-plugins
import gulp from 'gulp';
import del from 'del';
import postscss from 'postcss-scss';
import reporter from 'postcss-reporter';

const BROWSERSYNC = require('browser-sync').create();
const $ = require('gulp-load-plugins')(OPTIONS.loadplugins);

// Utility Tasks
// -----------------------------------------------------------------------------
// Store a copy of the theme as is before any changes are made into  a .tmp folder
gulp.task('set-up', () => {
  return gulp
    .src([
      './**/*',
      './.babelrc',
      './.editorconfig',
      './.eslintrc.json',
      './.stylelintrc',
      './.gitignore',
      '!./node_modules',
      '!./node_modules/**/*'
    ])
    .pipe(gulp.dest('./.tmp'));
});

// Delete compiled CSS files and sourcemap(s)
gulp.task('clean:css', () => {
  del([
    `${PATHS.css}/*.css`,
    `${PATHS.css}/sourcemaps`
    ]);
});

// Delete the generated project JS file and sourcemap(s)
gulp.task('clean:js', () => {
  del([
    `${PATHS.js}/*.js`,
    `${PATHS.js}/sourcemaps`
  ]);
});

// Delete the generated project distribution folder
gulp.task('clean:dist', () => {
  del(`${PATHS.dist}`);
});

// Server Tasks
// -----------------------------------------------------------------------------
// Launch a development server
gulp.task('server', () => {
  if (!BROWSERSYNC.active) {
    BROWSERSYNC.init(OPTIONS.browsersync);
  }
});

// Sass/CSS Tasks
// -----------------------------------------------------------------------------
// Lint Sass/CSS via Stylelint
gulp.task('sass:lint', () => {
  return gulp
    .src(SOURCES.sass)
    .pipe($.plumber())
    .pipe($.stylelint(OPTIONS.stylelint));
});

// Compile Sass to CSS, and create a sourcemap
gulp.task('sass', ['clean:css'], () => {
  return gulp
    .src(SOURCES.sass)
    .pipe($.sourcemaps.init())
    .pipe($.plumber())
    .pipe($.sass(OPTIONS.sass)
      .on('error', $.sass.logError))
    .on('error', $.notify.onError('Error compiling Sass!'))
    .pipe($.autoprefixer(OPTIONS.autoprefixer))
    .pipe($.sourcemaps.write('/sourcemaps'))
    .pipe($.plumber.stop())
    .pipe(gulp.dest(PATHS.css))
    .pipe(BROWSERSYNC.stream());
});

// Optimize the compiled CSS via CSSNano
// Not needed if you will use a plug-in that will do this
gulp.task('sass:minify', ['sass'], () => {
  return gulp
    .src(SOURCES.css)
    .pipe($.plumber())
    .pipe($.cssnano(OPTIONS.cssnano))
    .pipe($.rename({
      suffix: '.min',
      extname: '.css'
    }))
    .pipe(gulp.dest(PATHS.css))
    .pipe(BROWSERSYNC.stream());
});

// JS Tasks
// -----------------------------------------------------------------------------
// Lint JavaScript via ESLint
gulp.task('js:lint', () => {
  return gulp
    .src('./assets/js/theme/*.js')
    .pipe($.plumber())
    // .pipe($.babel())
    .pipe($.eslint())
    .pipe($.eslint.format())
    .pipe($.eslint.failAfterError());
});

// Concatenate JavaScript into one file, and create a sourcemap
gulp.task('js', ['clean:js'], () => {
  return gulp
    .src(SOURCES.concat)
    .pipe($.sourcemaps.init())
    .pipe($.plumber())
    // .pipe($.babel())
    .pipe($.print())
    .pipe($.concat('theme.js'))
    .pipe($.sourcemaps.write('/sourcemaps'))
    .pipe($.plumber.stop())
    .pipe(gulp.dest(PATHS.js));
});

// Minify the concatenated JavaScript file
// Not needed if you will use a plug-in that will do this
gulp.task('js:minify', ['js'], () => {
  return gulp
    .src(`${PATHS.js}/theme.js`)
    .pipe($.plumber())
    .pipe($.uglify())
    .pipe($.rename({
      suffix: '.min',
      extname: '.js'
    }))
    .pipe($.plumber.stop())
    .pipe(gulp.dest(PATHS.js))
    .pipe(BROWSERSYNC.stream());
});

// Image Tasks
// -----------------------------------------------------------------------------
// Optimize images via Imagemin
// Best to do this only once
gulp.task('images', () => {
  return gulp
    .src(SOURCES.images)
    .pipe($.plumber())
    .pipe($.imagemin(OPTIONS.imagemin))
    .pipe($.print())
    .pipe(gulp.dest(PATHS.images));
});

// Packaging Tasks
// -----------------------------------------------------------------------------
// Copy all files (except the development files) to a distribution folder
gulp.task('package', ['clean:dist', 'sass:minify', 'js:minify', 'images'], () => {
  return gulp
    .src([
      `${PATHS.root}**/*`,
      `!${PATHS.root}.tmp`,
      `!${PATHS.root}.tmp/**/*`,
      `!${PATHS.root}.git`,
      `!${PATHS.root}.git/**/*`,
      `!${PATHS.root}node_modules`,
      `!${PATHS.root}node_modules/**/*`,
      `!${PATHS.dist}`,
      `!${PATHS.dist}/**/*`,
      `!${PATHS.sass}`,
      `!${PATHS.sass}/**/*`,
      `!${PATHS.css}/sourcemaps`,
      `!${PATHS.css}/sourcemaps/*`,
      `!${PATHS.js}/sourcemaps`,
      `!${PATHS.js}/sourcemaps/*`,
      `!${PATHS.js}/theme`,
      `!${PATHS.js}/theme/**/*`,
      `!${PATHS.js}/vendor`,
      `!${PATHS.js}/vendor/**/*`,
      `!${PATHS.root}.babelrc`,
      `!${PATHS.root}.editorconfig`,
      `!${PATHS.root}.eslintrc.json`,
      `!${PATHS.root}.gitignore`,
      `!${PATHS.root}.stylelintrc`,
      `!${PATHS.root}gulpfile.babel.js`,
      `!${PATHS.root}package.json`,
      `!${PATHS.root}README.md`
    ])
    .pipe(gulp.dest(PATHS.dist + `${PROJECT}`));
});

// Zip up the packaged folder
gulp.task('zip', () => {
  return gulp
    .src(`${PATHS.dist}/${PROJECT}/**/*`)
    .pipe($.zip(`${PROJECT}.zip`))
    .pipe(gulp.dest(PATHS.dist));
});

// Defaults
// -----------------------------------------------------------------------------
// Watch files for changes
gulp.task('watch', () => {
  gulp.watch(SOURCES.sass, ['sass']);
  gulp.watch(SOURCES.js, ['js']);
  gulp.watch(SOURCES.php, BROWSERSYNC.reload);
  gulp.watch(SOURCES.html, BROWSERSYNC.reload);
});

// Default task
gulp.task('default', ['set-up', 'sass', 'js', 'watch', 'server']);
