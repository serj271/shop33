'use strict'
const gulp = require('gulp');
const del = require('del');
const debug = require('gulp-debug');
const stylus = require('gulp-stylus');
const sourcemaps = require('gulp-sourcemaps');
const vfs = require('vinyl-fs');
//const chmod = require('gulp-chmod');
const concat = require('gulp-concat');
const gulpIf = require('gulp-if');
const newer = require('gulp-newer');
const autoprefixer = require('gulp-autoprefixer');
const remember = require('gulp-remember');
const path= require('path');
const header = require('gulp-header');
const cached = require('gulp-cached');
const notify = require('gulp-notify');
const combiner = require('stream-combiner2').obj;
const resolver = require('stylus').resolver;
const cssnano = require('gulp-cssnano');
const rev = require('gulp-rev');
var fontAwesomeStylus = require("fa-stylus");
const shell = require('gulp-shell');
const clean = require('gulp-clean');

const isDevelopment = !process.env.NODE_ENV || process.env.NODE_ENV == 'development';
//src  {base:'frontend'}

gulp.task('clean', function () {
    return del(['css/public',]);
});

gulp.task('clean:fonts', function () {
    return del(['css/fonts']);
});

gulp.task('clean:public', function () {
    return gulp.src('css/public/*.css', {read: false})
        .pipe(clean());
});

gulp.task('clean:css', function () {
    return gulp.src('*.css')
        .pipe(shell.task(['ls -l']));
});

gulp.task('styles', function () {
    return combiner(
        gulp.src('css/frontend/styles/**/*.styl', {base:'frontend'}),//{srtyl, css}
        cached('styles'),
        debug({title:'src'}),
        remember('styles'),
        gulpIf(isDevelopment ,sourcemaps.init()),
        stylus({
//            define: {
//                url:resolver()
 //           }
            use: [
               fontAwesomeStylus()
            ]
//            compress: false
        }),
        autoprefixer(),
        gulpIf(isDevelopment, sourcemaps.write()),
//        .pipe(header('/* head */\n'))
        concat('main.css'),
        gulpIf(!isDevelopment, cssnano()),
        rev(),
        gulp.dest('css/public'),
        rev.manifest('css.json'),
        debug({title:'manifest'}),
        gulp.dest('css')
    )
});

gulp.task('styles:css', function () {
    return combiner(
        gulp.src('css/frontend/styles/**/*.css', {base:'frontend'}),//{srtyl, css}
        cached('styles'),
        debug({title:'src'}),
        remember('styles'),
        gulpIf(isDevelopment ,sourcemaps.init()),
        stylus({
//            define: {
//                url:resolver()
            //           }
//            use: [
//                fontAwesomeStylus()
//            ]
//            compress: false
        }),
//        autoprefixer(),
        gulpIf(isDevelopment, sourcemaps.write()),
//        .pipe(header('/* head */\n'))
        concat('main-css.css'),
        gulpIf(!isDevelopment, cssnano()),
        rev(),
        gulp.dest('css/public'),
        rev.manifest('css.json'),
        debug({title:'manifest'}),
        gulp.dest('css')
    )
});

gulp.task('styles:pics', function () {
    return gulp.src('css/frontend/styles/pics/**/*.*')
        .pipe(debug({title:'pics'}))
        .pipe(gulp.dest('css/public/pics'));
})

gulp.task('vendor', function () {
    return gulp.src('css/frontend/styles/vendor/bootstrap**/*.*', {base:'css/frontend/styles'})
        .pipe(newer('public'))
        .pipe(debug({title:'vendor'}))
        .pipe(gulp.dest('css/public'));
});

gulp.task('assets', function () {
    return gulp.src('frontend/assets/**/*.*')
        .pipe(newer('public'))
        .pipe(debug({title:'assets'}))
        .pipe(gulp.dest('public'));
});

gulp.task('awesome:fonts', function () {
    return gulp.src('node_modules/fa-stylus/fonts/**/*.*')
        .pipe(newer('public'))
        .pipe(debug({title:'awesome:fonts'}))
        .pipe(gulp.dest(process.cwd()+'/css/fonts'));
});


gulp.task('build', gulp.series('clean',gulp.parallel( 'styles', 'assets')));

gulp.task('watch', function () {
    gulp.watch('css/frontend/styles/**/*.styl', gulp.series('styles')).on('unlink',function (filepath) {
        remember.forget('styles', path.resolve(filepath));
        delete cached.caches.styles[path.resolve(filepath)];
    });
    gulp.watch('frontend/assets/**/*.*', gulp.series('assets'));
});

gulp.task('watch:styles', function () {
    gulp.watch('css/frontend/styles/**/*.styl', gulp.series('styles')).on('unlink',function (filepath) {
        remember.forget('styles', path.resolve(filepath));
        delete cached.caches.styles[path.resolve(filepath)];
    });

});

gulp.task('dev', gulp.series('build', 'watch'));

function lazyRequireTask(path) {
    var args = [].slice.call(arguments, 1);
    return function(callback) {
        var task = require(path).apply(this, args);
        return task(callback);
    };
}

gulp.task('client:compile-css',
    lazyRequireTask('./tasks/compileCss', {
        src: 'css/frontend/styles/**/*.styl',
        dst: 'css/public',
        publicDst: '',  // from browser point of view
        manifest: process.cwd() + '/css/styles.versions.json'
    })
);
gulp.task('client:minify-css',
    lazyRequireTask('./tasks/minifyCss', {
        src: 'css/frontend/styles/**/*.styl',
        dst: 'css/public',
        publicDst: '',  // from browser point of view
        manifest: process.cwd() + '/css/styles.versions.json'
    })
);