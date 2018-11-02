var gulp = require('gulp'),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat'),
    csso = require('gulp-csso'),
    gzip = require('gulp-gzip'),
    babel = require('gulp-babel');

gulp.task('js', function () {
    return gulp.src([
        './src/app/js/*.js',
        './src/app/js/widgets/*.js',
    ])
        //.pipe(uglify())
        .pipe(babel({
            presets: ['@babel/env']
        }))
        .pipe(concat('script.min.js'))
        // .pipe(gzip())
        .pipe(gulp.dest('./web/public/dist'));
});

gulp.task('css', function () {
    return gulp.src([
        './src/app/css/*.css',
    ])
        .pipe(csso())
        .pipe(concat('style.min.css'))
        // .pipe(gzip())
        .pipe(gulp.dest('./web/public/dist'));
});

gulp.task('app', ['js', 'css']);

gulp.task('jsVendor', function () {
    return gulp.src([
        './src/vendors/jquery/*.js',
        './src/vendors/dialog/js/*.js',
        './src/vendors/slick/*.js',
        './src/vendors/uikit/js/*.js',
        './src/vendors/vue/*.js',
        './src/vendors/vuetify/*.js',
        './src/vendors/leaflet/js/*.js',
        './src/vendors/momentjs/*.js',
        './src/vendors/vanila-masker/*.js',
    ])
        //.pipe(uglify())
        .pipe(concat('vendor.min.js'))
        // .pipe(gzip())
        .pipe(gulp.dest('./web/public/dist'));
});

gulp.task('cssVendor', function () {
    return gulp.src([
        './src/vendors/**/*.css',
        './src/vendors/**/css/*.css',
    ])
        .pipe(csso())
        .pipe(concat('vendor.min.css'))
        // .pipe(gzip())
        .pipe(gulp.dest('./web/public/dist'));
});

gulp.task('vendor', ['jsVendor', 'cssVendor']);

gulp.task('default', ['app', 'vendor']);