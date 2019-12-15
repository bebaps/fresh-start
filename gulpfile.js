const localURL = 'sandbox.test';
const sourceFiles = {
  css: './src/css/**/*.scss',
  js: './src/js/**/*.js',
  images: './src/images/**/*',
  php: [
    './*.php',
    './**/*.php'
  ]
};
const dist = {
  css: './dist/css',
  js: './dist/js',
  images: './dist/images'
};
const options = {
  autoprefixer: {
    browsers: ['last 2 versions'],
    cascade: false
  },
  browsersync: {
    proxy: localURL
  },
  cssnano: {
    discardComments: {
      removeAll: true
    }
  },
  rename: {
    css: {
      suffix: '.min'
    },
    js: {
      suffix: '.min'
    }
  },
  sass: {
    outputStyle: 'expanded'
  },
  sourcemaps: {
    write: '/'
  },
  stylelint: {
    reporters: [{
      formatter: 'string',
      console: true
    }]
  }
};

const { src, dest, parallel, series, watch } = require('gulp');
const autoprefixer = require('autoprefixer');
const browsersync = require('browser-sync').create();
const cssnano = require('cssnano');
const del = require('del');
const babel = require('gulp-babel');
const eslint = require('gulp-eslint');
const imagemin = require('gulp-imagemin');
const postcss = require('gulp-postcss');
const plumber = require('gulp-plumber');
const rename = require('gulp-rename');
const sass = require('gulp-sass');
const sourcemaps = require('gulp-sourcemaps');
const stylelint = require('gulp-stylelint');
const uglify = require('gulp-uglify');
sass.compiler = require('node-sass');

// -----------------------------------------------------------------------------
// Server Tasks
// -----------------------------------------------------------------------------

// BrowserSync
function server() {
  browsersync.init(options.browsersync);
}

// BrowserSync Reload
function serverReload() {
  browsersync.reload();
}

// -----------------------------------------------------------------------------
// Sass Tasks
// -----------------------------------------------------------------------------

// Compile Sass
function css() {
  return src(sourceFiles.css)
    .pipe(sourcemaps.init())
    .pipe(plumber())
    .pipe(sass(options.sass).on('error', sass.logError)).on('error', notify.onError('Error compiling Sass!'))
    .pipe(dest(dist.css))
    .pipe(rename(options.rename.css))
    .pipe(postcss([autoprefixer(), cssnano()]))
    .pipe(sourcemaps.write(options.sourcemaps.write))
    .pipe(dest(dist.css))
    .pipe(browsersync.stream())
}

// Lint Sass via Stylelint
function lintCss() {
  return src(paths.css.scss)
    .pipe(plumber())
    .pipe(stylelint(options.stylelint));
}

// -----------------------------------------------------------------------------
// JS Tasks
// -----------------------------------------------------------------------------

// Lint JS via ESLint
function lintJs() {
  return src('./assets/js/theme/**/*.js')
    .pipe(plumber())
    .pipe(eslint())
    .pipe(eslint.format());
}

// Concatenate and minify JS, then create a sourcemap
function js() {
  return src(paths.js.concat)
    .pipe(sourcemaps.init())
    .pipe(plumber())
    .pipe(uglify())
    .pipe(rename(options.rename.js))
    .pipe(sourcemaps.write(options.sourcemaps.write))
    .pipe(gulp.dest(paths.js.dest))
    .pipe(browsersync.stream());
}

// -----------------------------------------------------------------------------
// Image Tasks
// -----------------------------------------------------------------------------

// Optimize images via Imagemin, best to do this only once
function images() {
  return src(paths.images.images)
    .pipe(plumber())
    .pipe(imagemin())
    .pipe(gulp.dest(paths.images.dest));
}

// -----------------------------------------------------------------------------
// Defaults
// -----------------------------------------------------------------------------

function watchFiles() {
  watch(sourceFiles.css, css)
}

exports.css = css;
exports.js = js;
exports.server = server;
exports.watchFiles = watchFiles;
exports.default = series(css, server, watchFiles);
