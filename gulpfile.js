var gulp = require('gulp'),
	plugins = require('gulp-load-plugins')();

var themeName = 'emmanuelb',
	path = {
		prod: {
			root: './',
			css: './css',
			js: './js',
			img: './images',
			maps: './maps'
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
		.pipe(plugins.plumber())
			.pipe(plugins.sourcemaps.init())
				.pipe(plugins.stylus({
					compress: true
				}))
				.pipe(plugins.autoprefixer({
					browsers: ['last 3 versions'],
					cascade: false
				}))
				.pipe(plugins.rename('style.css'))
			.pipe(plugins.sourcemaps.write(path.prod.maps))
		.pipe(plugins.plumber.stop())
		.pipe(gulp.dest(path.prod.root))
		.pipe(plugins.livereload());
});

/**
 * Compile les fichiers coffee en javascript
 **/
gulp.task('coffeescript', function() {
	return gulp.src(path.dev.coffee + '/*.coffee')
		.pipe(plugins.plumber())
			.pipe(plugins.coffee({
				bare: true
			}).on('error', plugins.util.log))
		.pipe(plugins.plumber.stop())
		.pipe(gulp.dest(path.dev.js))
		.pipe(plugins.livereload());
});

/**
 * Sauvegarde et compresse les fichiers JS dans un fichier minifié
 * Crée un fichier sourcemap dans /maps/
 **/
gulp.task('javascript', function() {
	return gulp.src([path.dev.js + '/vendors/*.js', path.dev.js + '/plugins/*.js', path.dev.js + '/*.js'])
		.pipe(plugins.plumber())
			.pipe(plugins.sourcemaps.init())
				.pipe(plugins.uglify({
					preserveComments: 'some'
				}))
				.pipe(plugins.concat('main.min.js'))
			.pipe(plugins.sourcemaps.write('../maps'))
		.pipe(plugins.plumber.stop())
		.pipe(gulp.dest(path.prod.js))
		.pipe(plugins.livereload());
});

/**
 * Compresse les images
 **/
gulp.task('images', function() {
	return gulp.src(path.dev.img + '/**/*')
		.pipe(plugins.imagemin())
		.pipe(gulp.dest(path.prod.img));
});

gulp.task('default', ['stylus', 'coffeescript', 'javascript', 'images'], function() {
});

gulp.task('watch', function() {
	plugins.livereload.listen();
	gulp.watch(path.dev.stylus + '/**/*.styl', ['stylus']);
	gulp.watch(path.dev.js + '/**/*.js', ['javascript']);
	gulp.watch(path.dev.coffee + '/**/*.coffee', ['coffeescript', 'javascript']);
});
