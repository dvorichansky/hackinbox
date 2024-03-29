const gulp = require('gulp');
const concat = require('gulp-concat');
const autoprefixer = require('gulp-autoprefixer');
const cleanCSS = require('gulp-clean-css');
const uglify = require('gulp-uglify-es').default;
const babel = require('gulp-babel');

function styles() {
  return gulp.src('./hackinbox/css/hackinbox.css')
    .pipe(concat('hackinbox.min.css'))
    .pipe(autoprefixer({
      overrideBrowserslist: ['last 2 versions'],
      cascade: false
    }))
    .pipe(cleanCSS({
      level: 2
    }))
    .pipe(gulp.dest('./hackinbox/css'))
}

function scripts() {
  return gulp.src('./hackinbox/js/hackinbox.js')
    .pipe(babel({
      presets: ['@babel/env'],
      plugins: ["@babel/plugin-proposal-class-properties"]
    }))
    .pipe(concat('hackinbox.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest('./hackinbox/js'))
}

gulp.task('min_css', gulp.series(styles));
gulp.task('min_js', gulp.series(scripts));

gulp.task('watch', () => {
  gulp.watch(['./hackinbox/css/hackinbox.css'], (done) => {
      gulp.series('min_css')(done);
  });
  gulp.watch(['./hackinbox/js/hackinbox.js'], (done) => {
      gulp.series('min_js')(done);
  });
});