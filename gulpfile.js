var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var cssmin = require('gulp-cssmin');
var rename = require('gulp-rename');
var jsmin = require('gulp-jsmin');
var concat = require('gulp-concat');

var base_path = {
  src: './resources/assets',
  dst: './public/assets'
}

var path = {
  'src' : {
    css: base_path.src + '/sass/style.scss',
    js: base_path.src + '/js/vanil-js/**/*.js',
    angular: base_path.src + '/js/angular-app/**/*',
  },
  'dst' : {
    css: base_path.dst + '/css/',
    js: base_path.dst + '/js/',
    angular: base_path.dst + '/js/angular-app/',
  },
};

gulp.task('js', function () {
    return gulp.src(path.src.js)
      .pipe(concat('scripts.js'))
      .pipe(gulp.dest(path.dst.js))
        .pipe(jsmin())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest(path.dst.js));
});

gulp.task('angular', function () {
    return gulp.src(path.src.angular)
      .pipe(gulp.dest(path.dst.angular));
});

gulp.task('sass', function () {
  return gulp.src(base_path.src + '/sass/**/*')
    .pipe(sass().on('error', sass.logError))
    .pipe(autoprefixer({
          browsers: ['last 2 versions'],
          cascade: true
        }))
      .pipe(gulp.dest(path.dst.css))
      .pipe(cssmin())
      .pipe(rename({suffix: '.min'}))
      .pipe(gulp.dest(path.dst.css));
});

gulp.task('watch', function(){
  gulp.watch('./resources/assets/sass/*', ['sass']);
  gulp.watch(path.src.js, ['js']);
  gulp.watch(path.src.angular, ['angular']);
});


gulp.task('default', ['sass', 'js', 'angular', 'watch']);



