var gulp = require('gulp'),
	plugins = require('gulp-load-plugins')();

var themeName = 'emmanuelb',
	path = {
		fonts: {
			src: 'dev/fonts/',
			dest: 'fonts/'
		},
		images: {
			src: 'dev/images/',
			dest: 'img/'
		},
		maps: {
			dest: '../maps/'
		},
		scripts: {
			src: {
				coffee: 'dev/coffeescript/',
				js: 'dev/javascript/'
			},
			dest: 'js/'
		},
		styles: {
			src: 'dev/stylus/',
			dest: '/'
		}
	};

/**
 * livereload
 */
gulp.task('reload', function() {
	plugins.livereload();
});

/**
 * Sauvegarde et compresse les fichiers stylus dans un unique fichier .css
 * Garde le comportement @require de stylus
 * Crée un fichier sourcemap dans /maps/
 **/
gulp.task('stylus', function() {
	return gulp.src(path.styles.src + 'main.styl')
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
		.pipe(plugins.sourcemaps.write(path.styles.dest + 'maps'))
		.pipe(plugins.plumber.stop())
		.pipe(gulp.dest(path.styles.dest))
		.pipe(plugins.livereload());
});

/**
 * Compile les fichiers coffee en javascript
 **/
gulp.task('coffeescript', function() {
	return gulp.src(path.scripts.src.coffee + 'main.coffee')
		.pipe(plugins.plumber())
		.pipe(plugins.coffee({
			bare: true
		}).on('error', plugins.util.log))
		.pipe(plugins.plumber.stop())
		.pipe(gulp.dest(path.scripts.src.js))
		.pipe(plugins.livereload());
});

/**
 * Sauvegarde et compresse les fichiers JS dans un fichier minifié
 * Crée un fichier sourcemap dans /maps/
 **/
gulp.task('javascript', function() {
	return gulp.src([path.scripts.src.js + 'vendors/*.js', path.scripts.src.js+ 'plugins/*.js', path.scripts.src.js + '*.js'])
		.pipe(plugins.plumber())
		.pipe(plugins.sourcemaps.init())
		.pipe(plugins.uglify({
			preserveComments: 'some'
		}))
		.pipe(plugins.concat('main.min.js'))
		.pipe(plugins.sourcemaps.write(path.maps.dest))
		.pipe(plugins.plumber.stop())
		.pipe(gulp.dest(path.scripts.dest))
		.pipe(plugins.livereload());
});

/**
 * Compresse les images
 **/
gulp.task('images', function() {
	return gulp.src(path.images.src + '**/*')
		.pipe(plugins.cache(plugins.imagemin()))
		.pipe(gulp.dest(path.images.dest));
});

/**
 * Tâches de watch
 */
gulp.task('watch', function() {
	plugins.livereload.listen();
	gulp.watch(path.styles.src + '**/*.styl', ['stylus']);
	gulp.watch(path.scripts.src.js + '**/*.js', ['javascript']);
	gulp.watch(path.scripts.src.coffee + '**/*.coffee', ['coffeescript', 'javascript']);
	gulp.watch('**/*.php', ['reload']);
});

gulp.task('default', ['stylus', 'coffeescript', 'javascript', 'images']);