'use strict';
 
var browserSync = require('browser-sync').create();
var gulp = require('gulp');
var watch = require('gulp-watch');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var uglify = require('gulp-uglify');
// var jshint = require('gulp-jshint');
// var stylish = require('jshint-stylish');
var csso = require('gulp-csso');
var sourcemaps = require('gulp-sourcemaps');
var concat = require('gulp-concat');
var del = require('del');
var imagemin = require('gulp-imagemin');
var pngquant = require('imagemin-pngquant');
var babel = require('gulp-babel');
var prettify = require('gulp-prettify');
var path = require('path');

var templates_dir = path.join(__dirname, '../') + '**/*.html';

gulp.task('default', ['browser-sync', 'sass', 'compressjs', 'concatjs', 'libs', 'compressimages', 'html-prettify'], function () {
    gulp.watch("./assets/src/sass/**/*.scss", ['sass']);
    gulp.watch("./assets/src/js/**/*.js", ['compressjs']);
    gulp.watch("./assets/src/js.concat/**/*.js", ['concatjs']);
    gulp.watch("./assets/src/libs/**", ['libs']);
    gulp.watch("./assets/src/images/**", ['compressimages']);
    gulp.watch('./assets/src/templates/**/*.html', ['html-prettify']);
});

gulp.task('prod', ['sass', 'compressjs', 'concatjs', 'libs', 'compressimages']);

gulp.task('clean', function () {
    del(['./assets/dist/**'], function (err, deletedFiles) {
    console.log('Files deleted!'); });
});

gulp.task('browser-sync', function() {
    browserSync.init({
        proxy: "http://localhost/"
    });
});


gulp.task('sass', function () {
  gulp.src('./assets/src/sass/**/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer())
    .pipe(sourcemaps.init())
    .pipe(sourcemaps.write('./'))
    .pipe(gulp.dest('./assets/dist/css/'))
    .pipe(browserSync.stream())
});


gulp.task('compressjs', function () {
  gulp.src('./assets/src/js/**/*.js')
    // .pipe(jshint())
    // .pipe(jshint.reporter('jshint-stylish'))
    // .pipe(jshint.reporter('fail'))
    .pipe(gulp.dest('./assets/dist/js/'))
    .pipe(browserSync.stream())
});



gulp.task('concatjs', function () {
  gulp.src('./assets/src/js.concat/**/*.js')
    // .pipe(jshint())
    // .pipe(jshint.reporter('jshint-stylish'))
    // .pipe(jshint.reporter('fail'))
    .pipe(concat('combined.js'))
    .pipe(gulp.dest('./assets/dist/js/'))
    .pipe(browserSync.stream())
});


gulp.task('libs', function() {
  gulp.src('./assets/src/libs/**/*')
    .pipe(gulp.dest('./assets/dist/libs/'))
    // .pipe(browserSync.stream())
});



gulp.task('compressimages', function() {
  gulp.src('./assets/src/images/**')
    .pipe(imagemin({
        optimizationLevel: 4, 
        progressive: true,
        svgoPlugins: [{removeViewBox: false}],
        use: [pngquant()]
    }))
    .pipe(gulp.dest('./assets/dist/images/'))
    .pipe(browserSync.stream())
});

gulp.task('html-prettify', function() {
  gulp.src('./assets/src/templates/*.html')
    .pipe(prettify({indent_size: 3}))
    .pipe(gulp.dest('./'))
    .pipe(browserSync.stream())
});

// ------------------ UNITY DJANGO TASKS ----------------------------

// gulp.task('libs', function() {
//   gulp.src('./assets/src/libs/**')
//     .pipe(gulp.dest('./assets/dist/libs/'))
//     .pipe(browserSync.stream())
// });