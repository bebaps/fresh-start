'use strict';

// Define the local URL used for development
const localURL = 'wordpress.dev';

// Give this project a name, used for the distribution folder
const project = 'fresh-start';

// Define the paths to be used
const paths = {
  temp: './.tmp/',
  dist: './_dist',
  css: {
    dest: './assets/css',
    scss: './assets/sass/**/*.scss',
    css: [
      './assets/css/**/*.css',
      '!./assets/css/**/*.min.css'
    ]
  },
  js: {
    dest: './assets/js',
    js: './assets/js/**/*.js',
    concat: [
      './node_modules/clear-menu/src/clearmenu.js',
      './assets/js/vendor/*.js',
      './assets/js/theme/skip-link-focus-fix.js',
      // './assets/js/theme/load-more.js',
      './assets/js/theme/scripts.js'
    ]
  },
  images: {
    dest: './assets/images',
    images: './assets/images/**/*.{jpg,png,gif,svg}'
  },
  php: [
    './*.php',
    './**/*.php'
  ]
};

// Set options for the Gulp plugins
const options = {
  autoprefixer: {
    browsers: [ 'last 2 versions' ],
    cascade: false
  },
  browsersync: {
    proxy: localURL,
    ghostMode: false,
    browser: 'google chrome'
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
  rename: {
    css: {
      suffix: '.min'
    },
    js: {
      suffix: '.min'
    }
  },
  sass: {
    includePaths: [
      './node_modules/sass-mediaqueries/',
      './node_modules/clear-menu/src'
    ],
    outputStyle: 'expanded'
  },
  sourcemaps: {
    write: '/'
  },
  stylelint: {
    reporters: [ {
      formatter: 'string',
      console: true
    } ]
  }
};

// Include gulp and plugins not targeted by gulp-load-plugins
import gulp from 'gulp';
import del from 'del';
const browsersync = require( 'browser-sync' ).create();
const $ = require( 'gulp-load-plugins' )( options.loadplugins );

// Utility Tasks
// -----------------------------------------------------------------------------
// Store a copy of the theme before any changes are made
gulp.task( 'set-up', () => {
  return gulp
    .src( [
      './**/*',
      './**/.*',
      '!./node_modules',
      '!./node_modules/**/*'
    ] )
    .pipe( gulp.dest( paths.temp ) );
});

// Delete the distribution folder
gulp.task( 'clean:dist', () => {
  del( `${paths.dist}` );
});

// Server Tasks
// -----------------------------------------------------------------------------
// Launch a development server
gulp.task( 'server', [ 'sass', 'js' ], () => {
  browsersync.init( options.browsersync );
  gulp.watch( paths.php ).on( 'change', browsersync.reload );
  gulp.watch( paths.css.scss, [ 'sass' ] );
  gulp.watch( './assets/js/theme/*.js', [ 'js' ] );
});

// Sass Tasks
// -----------------------------------------------------------------------------
// Lint Sass via Stylelint
gulp.task( 'lint:sass', () => {
  return gulp
    .src( paths.css.scss )
    .pipe( $.plumber() )
    .pipe( $.stylelint( options.stylelint ) );
});

// Compile and minify Sass, then create a sourcemap
gulp.task( 'sass', () => {
  return gulp
    .src( paths.css.scss )
    .pipe( $.sourcemaps.init() )
    .pipe( $.plumber() )
    .pipe( $.sass( options.sass )
      .on( 'error', $.sass.logError ) )
    .on( 'error', $.notify.onError( 'Error compiling Sass!' ) )
    .pipe( $.cssnano( options.cssnano ) )
    .pipe( $.rename( options.rename.css ) )
    .pipe( $.sourcemaps.write( options.sourcemaps.write ) )
    .pipe( gulp.dest( paths.css.dest ) )
    .pipe( browsersync.stream() );
});

// JS Tasks
// -----------------------------------------------------------------------------
// Lint JS via ESLint
gulp.task( 'lint:js', () => {
  return gulp
    .src( './assets/js/theme/**/*.js' )
    .pipe( $.plumber() )
    .pipe( $.eslint() )
    .pipe( $.eslint.format() );
});

// Concatenate and minify JS, then create a sourcemap
gulp.task( 'js', () => {
  return gulp
    .src( paths.js.concat )
    .pipe( $.sourcemaps.init() )
    .pipe( $.plumber() )
    // .pipe($.babel())
    .pipe( $.concat( 'theme.js' ) )
    .pipe( $.uglify() )
    .pipe( $.rename( options.rename.js ) )
    .pipe( $.sourcemaps.write( options.sourcemaps.write ) )
    .pipe( gulp.dest( paths.js.dest ) )
    .pipe( browsersync.stream() );
});

// Image Tasks
// -----------------------------------------------------------------------------
// Optimize images via Imagemin, best to do this only once
gulp.task( 'images', () => {
  return gulp
    .src( paths.images.images )
    .pipe( $.plumber() )
    .pipe( $.imagemin() )
    .pipe( gulp.dest( paths.images.dest ) );
});

// Packaging Tasks
// -----------------------------------------------------------------------------
// Copy all files (except the development files) to a distribution folder
gulp.task( 'package', [ 'clean:dist', 'sass:minify', 'js', 'images' ], () => {
  return gulp
    .src( [
      './**/*',
      './.*',
      '!./node_modules',
      '!./node_modules/**/*',
      `!${paths.temp}`,
      `!${paths.temp}/**/*`,
      `!${paths.dist}`,
      `!${paths.dist}/**/*`,
      `!${paths.css.dest}/*.map`,
      '!./assets/sass',
      '!./assets/sass/**/*',
      `!${paths.js.dest}/*.map`,
      `!${paths.js.dest}/theme`,
      `!${paths.js.dest}/theme/**/*`,
      `!${paths.js.dest}/vendor`,
      `!${paths.js.dest}/vendor/**/*`,
      '!./gulpfile.babel.js',
      '!./package.json',
      '!./README.md'
    ] )
    .pipe( gulp.dest( `${paths.dist}/${project}` ) );
});

// Zip up the distribution theme
gulp.task( 'zip', () => {
  return gulp
    .src( `${paths.dist}/${project}/**/*` )
    .pipe( $.zip( `${project}.zip` ) )
    .pipe( gulp.dest( paths.dist ) );
});

// Defaults
// -----------------------------------------------------------------------------
gulp.task( 'default', [ 'server' ] );
