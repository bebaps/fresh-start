const localURL = 'sandbox.test';
const sourceFiles = {
  images: './src/images/**/*',
  php: './**/*.php'
};
const dist = {
  images: './dist/images'
};
const options = {
  cssnano: {
    discardComments: {
      removeAll: true
    }
  }
};

const { src, dest, parallel, series, watch } = require('gulp');
const autoprefixer = require('autoprefixer');
const browsersync = require('browser-sync').create();
const cssnano = require('cssnano');
const del = require('del');
const babel = require('gulp-babel');
const imagemin = require('gulp-imagemin');
const notify = require('gulp-notify');
const postcss = require('gulp-postcss');
const plumber = require('gulp-plumber');
const rename = require('gulp-rename');
const sass = require('gulp-sass');
const sourcemaps = require('gulp-sourcemaps');
const uglify = require('gulp-uglify');
sass.compiler = require('node-sass');

// -----------------------------------------------------------------------------
// Server Tasks
// -----------------------------------------------------------------------------

// BrowserSync
function server() {
  browsersync.init({
    proxy: localURL
  });
}

// BrowserSync Reload
function serverReload() {
  browsersync.reload();
}

// -----------------------------------------------------------------------------
// Sass Tasks
// -----------------------------------------------------------------------------

// Compile Sass to CSS
function css() {
  return src('src/css/**/*.scss')
    .pipe(sourcemaps.init())
    .pipe(plumber())
    .pipe(sass().on('error', sass.logError)).on('error', notify.onError('Error compiling Sass!'))
    .pipe(sourcemaps.write())
    .pipe(dest('dist/css'))
    .pipe(browsersync.stream());
}

// Minify CSS
function optimizeCss() {
  return src('dist/css/**/*.css')
    .pipe(plumber())
    .pipe(rename({suffix: '.min'}))
    .pipe(postcss([autoprefixer(), cssnano(options.cssnano)]))
    .pipe(dest('dist/css'))
    .pipe(browsersync.stream());
}

// -----------------------------------------------------------------------------
// JS Tasks
// -----------------------------------------------------------------------------

// Transpile ES6
function js() {
  return src('src/js/**/*.js')
    .pipe(sourcemaps.init())
    .pipe(plumber())
    .pipe(babel())
    .pipe(sourcemaps.write())
    .pipe(dest('dist/js'))
    .pipe(browsersync.stream());
}

function optimizeJs() {
  return src('dist/js/**/*.js')
    .pipe(plumber())
    .pipe(rename({suffix: '.min'}))
    .pipe(uglify())
    .pipe(dest('dist/js'))
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
exports.optimizeCss = optimizeCss;
exports.js = js;
exports.optimizeJs = optimizeJs;
exports.server = server;
exports.watchFiles = watchFiles;
exports.default = series(css, server, watchFiles);
