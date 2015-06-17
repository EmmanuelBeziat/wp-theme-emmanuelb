var gulp = require('gulp'),
	stylus = require('gulp-stylus'),
	concat = require('gulp-concat'),
	uglify = require('gulp-uglify'),
	rename = require('gulp-rename'),
	sourcemaps = require('gulp-sourcemaps'),
	imagemin = require('gulp-imagemin');

/**
 * Sauvegarde et compresse les fichiers stylus dans un unique fichier style.css
 * Garde le comportement @require de stylus
 * Crée un fichier sourcemap dans /maps/
 **/
gulp.task('stylus', function() {
	return gulp.src('stylus/style.styl')
		.pipe(sourcemaps.init())
			.pipe(stylus({
				compress: true
			}))
		.pipe(sourcemaps.write('../maps'))
		.pipe(gulp.dest(''));
});

/**
 * Sauvegarde et compresse les fichiers JS dans un fichier minifié
 * Crée un fichier sourcemap dans /maps/
 **/
gulp.task('javascript', function() {
	return gulp.src(['js/vendors/*.js', 'js/plugins/*.js', 'js/main.js'])
		.pipe(sourcemaps.init())
			.pipe(uglify({
				preserveComments: 'some'
			}))
			.pipe(concat('main.min.js'))
		.pipe(sourcemaps.write('../maps'))
		.pipe(gulp.dest('js/'));
});

/**
 * Compresse les images
 **/
gulp.task('images', function() {
	return gulp.src('images/**/*')
		.pipe(imagemin())
		.pipe(gulp.dest('images'));
});

gulp.task('default', ['stylus', 'javascript', 'images'], function() {
});

gulp.task('watch', function() {
	gulp.watch('stylus/*.styl', ['stylus']);
	gulp.watch('js/*.js', ['javascript']);
});
