// Load plugins
var gulp    = require('gulp'),
	merge   = require('merge-stream'),
	wpPot   = require('gulp-wp-pot'),
	zip     = require('gulp-zip'),
	del     = require('del');

gulp.task('translate', function () {
	return gulp.src('./**/*.php')
		.pipe(wpPot({
			domain: 'matador-extension-custom-lhs',
			package: 'Matador Jobs Custom Extension for Lead Health Staffing'
		}))
		.pipe(gulp.dest('languages/matador-extension-custom-lhs.pot'));
});

gulp.task('clean', function () {
	return del([
		'dist/*',
	]);
});

gulp.task('package', function () {
	var
	dist = 'dist/',

	languages = gulp.src(['./languages/**']).pipe(gulp.dest(dist+'languages')),

	root = gulp.src([
		'./index.php',
		'./readme.txt',
		'./license.txt',
		'./Extension.php',
		'./matador-jobs-custom-lhs.php',
	]).pipe(gulp.dest(dist)),

	vendor = gulp.src([
		'./vendor/**',
	]).pipe(gulp.dest(dist+'vendor')),

	src = gulp.src([
		'./src/**/*.php',
	]).pipe(gulp.dest(dist+'src')),

	templates = gulp.src([
		'./templates/**'
	]).pipe(gulp.dest(dist+'templates'));

	return merge(templates, src, vendor, languages, root);
});

gulp.task('zip', function () {
	var dist = 'dist/';

	return gulp.src([dist+'**']).pipe(zip('matador-jobs-custom-lhs.zip')).pipe(gulp.dest(dist));
});

// When upgrading to Gulp 4, we need to convert this to gulp.series as translate may not finish before 'package'
gulp.task('default', function () {
	gulp.start('translate','clean','package','zip');
});