'use strict';

// Define the local URL used for development
// See https://browsersync.io/docs/options/#option-proxy
const LOCALURL = 'wordpress.dev';

// Give this project a name, used for the distribution folder
const PROJECT = 'freshstart';

// Define the paths to be used
const PATHS = new function () {
  this.dist = './_dist/',
    this.assets = './assets',
    this.css = `${this.assets}/css`,
    this.js = `${this.assets}/js`,
    this.fonts = `${this.assets}/fonts`,
    this.images = `${this.assets}/images`,
    this.sass = `${this.assets}/sass`;
};

// Define the sources to be used
const SOURCES = {
  php: [
    './*.php',
    './**/*.php'
  ],
  css: [
    `${PATHS.css}/*.css`,
    `!${PATHS.css}/*.min.css`
  ],
  sass: [
    `${PATHS.sass}/**/*.scss`
  ],
  js: [
    `${PATHS.js}/**/*.js`
  ],
  images: [
    `${PATHS.images}/**/*.{jpg,png,gif,svg}`
  ],
  concat: [ // Set the order for JS concatenation
    // './node_modules/jquery/dist/jquery.js',
    `${PATHS.js}/vendor/*.js`,
    `${PATHS.js}/theme/skip-link-focus-fix.js`,
    `${PATHS.js}/theme/scripts.js`
  ]
};

// Set options for the Gulp plugins
const OPTIONS = {
  autoprefixer: {
    browsers: [
      '> 1%', 'last 3 versions', 'Safari > 7'
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
// Store a copy of the theme before any changes are made
gulp.task('set-up', () => {
  return gulp
    .src([
      './**/*',
      './**/.*',
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

// Delete compiled JS files and sourcemap(s)
gulp.task('clean:js', () => {
  del([
    `${PATHS.js}/*.js`,
    `${PATHS.js}/sourcemaps`
  ]);
});

// Delete the distribution folder
gulp.task('clean:dist', () => {
  del(`${PATHS.dist}`);
});

// Server Tasks
// -----------------------------------------------------------------------------
// Launch a development server
gulp.task('server', ['sass', 'js'], () => {
  if (!BROWSERSYNC.active) {
    BROWSERSYNC.init(OPTIONS.browsersync);
  }
});

// Sass Tasks
// -----------------------------------------------------------------------------
// Lint Sass via Stylelint
gulp.task('sass:lint', () => {
  return gulp
    .src(SOURCES.sass)
    .pipe($.plumber())
    .pipe($.stylelint(OPTIONS.stylelint));
});

// Compile and minify Sass, then create a sourcemap
gulp.task('sass', ['clean:css'], () => {
  return gulp
    .src(SOURCES.sass)
    .pipe($.sourcemaps.init())
    .pipe($.plumber())
    .pipe($.sass()
      .on('error', $.sass.logError))
    .on('error', $.notify.onError('Error compiling Sass!'))
    .pipe($.autoprefixer(OPTIONS.autoprefixer))
    .pipe($.cssnano(OPTIONS.cssnano))
    .pipe($.rename({
      suffix: '.min'
    }))
    .pipe($.sourcemaps.write('/sourcemaps'))
    .pipe($.plumber.stop())
    .pipe(gulp.dest(PATHS.css))
    .pipe(BROWSERSYNC.stream());
});

// JS Tasks
// -----------------------------------------------------------------------------
// Lint JS via ESLint
gulp.task('js:lint', () => {
  return gulp
    .src('./assets/js/theme/*.js')
    .pipe($.plumber())
    // .pipe($.babel())
    .pipe($.eslint())
    .pipe($.eslint.format())
    .pipe($.eslint.failAfterError());
});

// Concatenate and minify JS, then create a sourcemap
gulp.task('js', ['clean:js'], () => {
  return gulp
    .src(SOURCES.concat)
    .pipe($.sourcemaps.init())
    .pipe($.plumber())
    // .pipe($.babel())
    .pipe($.print())
    .pipe($.concat('theme.js'))
    .pipe($.uglify())
    .pipe($.rename({
      suffix: '.min'
    }))
    .pipe($.sourcemaps.write('/sourcemaps'))
    .pipe($.plumber.stop())
    .pipe(gulp.dest(PATHS.js))
    .pipe(BROWSERSYNC.stream());
});

// Image Tasks
// -----------------------------------------------------------------------------
// Optimize images via Imagemin, best to do this only once
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
gulp.task('package', ['clean:dist', 'sass', 'js', 'images'], () => {
  return gulp
    .src([
      `./**/*`,
      `!./.*`,
      './node_modules',
      './node_modules/**/*',
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
      './gulpfile.babel.js',
      './package.json',
      './README.md'
    ])
    .pipe(gulp.dest(PATHS.dist + `${PROJECT}`));
});

// Zip up the distribution theme
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
});

// Default task
gulp.task('default', ['set-up', 'server', 'watch']);
