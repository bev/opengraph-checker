var gulp  = require('gulp'),
    gutil = require('gulp-util');

// Gulp Tasks
gulp.task('default', function() {
  return gutil.log('Gulp is running!')
});

gulp.task('hello', function() {
  console.log('Hello World');
});