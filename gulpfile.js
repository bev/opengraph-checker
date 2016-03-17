var gulp = require('gulp'),
	gutil = require('gulp-util'),
	sass = require('gulp-ruby-sass'),
	pleeease = require('gulp-pleeease'),
	sourcemaps = require('gulp-sourcemaps'),
	csscomb = require('gulp-csscomb');

/* Options */
var sassOptions = {
	style: 'expanded'
};

var pleeeaseOptions = { // set minifier to false to keep Sass sourcemaps support
	optimizers: {
		minifier: false
	}
};

/* Tasks */
gulp.task('css', function () {
	return sass('./src/css/*.scss', sassOptions)
	.on('error', sass.logError)
	.pipe(sourcemaps.write('maps', {
		includeContent: false,
		sourceRoot: 'source'
	}))
	.pipe(pleeease(pleeeaseOptions))
	.pipe(csscomb()) // CSSComb isn't working
	.pipe(gulp.dest('./dist/css'));
});

// My important watch task
gulp.task('watch', function(){
	gulp.watch('./src/css/*.scss', ['css']); 
})

gulp.task('default', function() {
	return gutil.log('Gulp is running!')
});

gulp.task('hello', function() {
	console.log('Hello World');
});
