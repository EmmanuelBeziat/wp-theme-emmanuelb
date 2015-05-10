var gulp = require('gulp'),
	stylus = require('gulp-stylus'),
	concat = require('gulp-concat'),
	uglify = require('gulp-uglify'),
	sourcemaps = require('gulp-sourcemaps'),
	rename = require('gulp-rename'),
	imagemin = require('gulp-imagemin'),
	templatePath = 'wp-content/themes/emmanuelb/';

/**
 * Sauvegarde et compresse les fichiers stylus dans un unique fichier style.css
 * Garde le comportement @require de stylus
 * Crée un fichier sourcemap dans /maps/
 **/
gulp.task('stylus', function() {
	return gulp.src(templatePath + 'stylus/style.styl')
		.pipe(sourcemaps.init())
			.pipe(stylus({
				compress: true
			}))
		.pipe(sourcemaps.write('maps'))
		.pipe(gulp.dest(templatePath));
});

/**
 * Sauvegarde et compresse les fichiers JS dans un fichier minifié
 * Crée un fichier sourcemap dans /maps/
 **/
gulp.task('javascript', function() {
	return gulp.src(templatePath + 'js/main.js')
		.pipe(sourcemaps.init())
			.pipe(uglify())
			.pipe(rename('main.min.js'))
		.pipe(sourcemaps.write('../maps'))
		.pipe(gulp.dest(templatePath + 'js/'));
});

/**
 * Compresse les images
 **/
gulp.task('images', function() {
	return gulp.src(templatePath + 'images/**/*')
		.pipe(imagemin())
		.pipe(gulp.dest(templatePath + 'images'));
});

gulp.task('default', ['stylus', 'javascript', 'images'], function() {
});

gulp.task('watch', function() {
	gulp.watch(templatePath + 'stylus/*.styl', ['stylus']);
	gulp.watch(templatePath + 'js/*.js', ['javascript']);
});
