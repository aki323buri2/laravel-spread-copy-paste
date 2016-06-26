var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

/*
elixir(function(mix) {
    mix.sass('app.scss');
});
*/
var gulp = require('gulp');

var plumber = require('gulp-plumber');
var replace = require('gulp-replace');
var flatten = require('gulp-flatten');

var sourcemaps = require('gulp-sourcemaps');
var less = require('gulp-less');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var rename = require('gulp-rename');
var path = require('path');
var prefix = {
	browsers: [
		'last 2 versions', 
		'> 1%', 
	]
};
gulp.task('vendor', function ()
{
	gulp.src('bower_components/**/*.*', {base: 'bower_components'})
		.pipe(gulp.dest('public/vendor'))
	;
});
gulp.task('reset', function ()
{
	var src = 'bower_components/semantic/src/**/*.*';
	var tar = 'hack/semantic/src';
	var fs = require('fs');
	if (fs.existsSync(tar))
	{
		throw fs + ' is already exists!!';
	}
	gulp.src(src)
		.pipe(gulp.dest(tar))
		.on('end', function ()
		{
			[
				['_site', 'site'], 
				['theme.config.example', 'theme.config'], 
			].map(function (todo)
			{
				var before = path.join(tar, todo[0]);
				var after  = path.join(tar, todo[1]);
				console.log(before + ' ==>> ' + after);
				fs.rename(before, after);
			});
		})
	;
});
gulp.task('semantic', function ()
{
	gulp.src('hack/semantic/src/definitions/**/*.less')
		.pipe(plumber())
		.pipe(sourcemaps.init())
		.pipe(less())
		.pipe(autoprefixer(prefix))
		.pipe(replace('../../themes', '../themes'))
		.pipe(flatten())
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest('public/build/semantic/components'))
	;
	gulp.src('hack/semantic/src/semantic.less')
		.pipe(plumber())
		.pipe(sourcemaps.init())
		.pipe(less())
		.pipe(autoprefixer(prefix))
		.pipe(replace('../../themes', 'themes'))
		.pipe(sourcemaps.write('.'))
		.pipe(gulp.dest('public/build/semantic'))
		.on('end', function ()
		{
			console.log('semantic.less created!!');
		})
	;
});
gulp.task('assets', function ()
{
	gulp.src('bower_components/semantic/src/themes/**/assets/**/*.*')
		.pipe(gulp.dest('public/build/semantic/themes'))
	;
});
gulp.task('watch', function ()
{
	gulp.watch('hack/semantic/+(src|hack)/**/**.*', ['semantic']);
});