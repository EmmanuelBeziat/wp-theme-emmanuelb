var gulp = require('gulp'),
	util = require('gulp-util'),
	stylus = require('gulp-stylus'),
	concat = require('gulp-concat'),
	uglify = require('gulp-uglify'),
	rename = require('gulp-rename'),
	coffee = require('gulp-coffee'),
	plumber = require('gulp-plumber'),
	imagemin = require('gulp-imagemin'),
	sourcemaps = require('gulp-sourcemaps'),
	autoprefixer = require('gulp-autoprefixer');

var path = {
	prod: {
		root: './',
		css: './css',
		js: './js',
		img: './images'
	},
	dev: {
		root: './dev/',
		stylus: './dev/stylus',
		coffee: './dev/coffeescript',
		maps: './dev/maps',
		img: './dev/images',
		js: './dev/javascript'
	}
};

/**
 * Sauvegarde et compresse les fichiers stylus dans un unique fichier .css
 * Garde le comportement @require de stylus
 * Crée un fichier sourcemap dans /maps/
 **/
gulp.task('stylus', function() {
	return gulp.src(path.dev.stylus + '/main.styl')
		.pipe(plumber())
			.pipe(sourcemaps.init())
				.pipe(stylus({
					compress: true
				}))
				.pipe(autoprefixer({
					browsers: ['last 3 versions'],
					cascade: false
				}))
				.pipe(rename('style.css'))
			.pipe(sourcemaps.write(path.dev.maps))
		.pipe(plumber.stop())
		.pipe(gulp.dest(path.prod.root));
});

/**
 * Compile les fichiers coffee en javascript
 **/
gulp.task('coffeescript', function() {
	return gulp.src(path.dev.coffee + '/*.coffee')
		.pipe(plumber())
			.pipe(coffee({
				bare: true
			}).on('error', util.log))
		.pipe(plumber.stop())
		.pipe(gulp.dest(path.dev.js));
});

/**
 * Sauvegarde et compresse les fichiers JS dans un fichier minifié
 * Crée un fichier sourcemap dans /maps/
 **/
gulp.task('javascript', function() {
	return gulp.src([path.dev.js + '/vendors/*.js', path.dev.js + '/plugins/*.js', path.dev.js + '/*.js'])
		.pipe(plumber())
			.pipe(sourcemaps.init())
				.pipe(uglify({
					preserveComments: 'some'
				}))
				.pipe(concat('main.min.js'))
			.pipe(sourcemaps.write('../dev/maps'))
		.pipe(plumber.stop())
		.pipe(gulp.dest(path.prod.js));
});

/**
 * Compresse les images
 **/
gulp.task('images', function() {
	return gulp.src(path.dev.img + '/**/*')
		.pipe(imagemin())
		.pipe(gulp.dest(path.prod.img));
});

gulp.task('default', ['stylus', 'coffeescript', 'javascript', 'images'], function() {
});

gulp.task('watch', function() {
	gulp.watch(path.dev.stylus + '/**/*.styl', ['stylus']);
	gulp.watch(path.dev.js + '/**/*.js', ['javascript']);
	gulp.watch(path.dev.coffee + '/**/*.coffee', ['coffeescript', 'javascript']);
});
