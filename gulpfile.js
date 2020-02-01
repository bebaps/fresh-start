const { src, dest, series, parallel, watch } = require('gulp');
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

const localUrl = 'https://sandbox.test';
const options = {
  cssnano: {
    discardComments: {
      removeAll: true
    }
  }
};

// -----------------------------------------------------------------------------
// Server
// -----------------------------------------------------------------------------

// BrowserSync
function server() {
  browsersync.init({
    proxy: localUrl
  });
  watch('src/scss/**/*.scss', css);
  watch('src/js/**/*.js', js);
  watch('src/images/**/*', images);
  watch(['./**/*.php', './**/*.twig']).on('change', browsersync.reload);
}

// -----------------------------------------------------------------------------
// Css
// -----------------------------------------------------------------------------

// Copy CSS files... for instance from node_modules
function copyCss() {
  return src([
    //
  ]).pipe(dest('dist/css/vendor'));
}

// Compile Sass to CSS
function css() {
  return src('src/scss/**/*.scss')
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
    .pipe(postcss([autoprefixer(), cssnano(options.cssnano)]))
    .pipe(dest('dist/css'))
    .pipe(browsersync.stream());
}

// Delete all CSS files
function cleanCss(cb) {
  del(['dist/css']);
  cb();
}

// -----------------------------------------------------------------------------
// JS
// -----------------------------------------------------------------------------

// Copy JS files... for instance from node_modules
function copyJs() {
  return src([
    //
  ]).pipe(dest('dist/js/vendor'));
}

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

// Optimize JS
function optimizeJs() {
  return src('dist/js/**/*.js')
    .pipe(plumber())
    .pipe(uglify())
    .pipe(dest('dist/js'))
    .pipe(browsersync.stream());
}

// Delete all JS files
function cleanJs(cb) {
  del(['dist/js']);
  cb();
}

// -----------------------------------------------------------------------------
// Images
// -----------------------------------------------------------------------------

// Optimize images
function images() {
  return src('src/images/**/*')
    .pipe(plumber())
    .pipe(imagemin())
    .pipe(dest('dist/images'));
}

// Delete all images
function cleanImages(cb) {
  del(['dist/images']);
  cb();
}

// -----------------------------------------------------------------------------
// Misc.
// -----------------------------------------------------------------------------

// Watch files for changes
function watchFiles() {
  watch('src/scss/**/*.scss', css);
  watch('src/js/**/*.js', js);
  watch('src/images/**/*', images);
  watch(['./**/*.php', './**/*.twig']).on('change', browsersync.reload);
}

// Delete all assets
function clean(cb) {
  del(['dist']);
  cb();
}

// -----------------------------------------------------------------------------
// Exports
// -----------------------------------------------------------------------------

exports.server = server;
exports.copyCss = copyCss;
exports.css = css;
exports.optimizeCss = optimizeCss;
exports.cleanCss = cleanCss;
exports.buildCss = series(cleanCss, css, optimizeCss);
exports.copyJs = copyJs;
exports.js = js;
exports.optimizeJs = optimizeJs;
exports.cleanJs = cleanJs;
exports.buildJs = series(cleanJs, js, optimizeJs);
exports.images = images;
exports.cleanImages = cleanImages;
exports.clean = clean;
exports.watchFiles = watchFiles;

exports.default = series(css, js, images, server);
