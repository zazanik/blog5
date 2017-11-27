let autoPrefix = require('gulp-autoprefixer');
let minCss = require('gulp-minify-css');
let gulp = require('gulp');
let sass = require('gulp-sass');
let rebaseUrls = require('gulp-css-rebase-urls');

const sassDistribution = {
    name: ['main.css', 'admin.css'],
    path: './web/dist/styles/',
    autoPrefix: {
        browsers: [
            'last 3 versions'
        ],
        cascade: false
    },
    nodePath: {
        includePaths: './node_modules/'
    }
};

/**
 * Build css distribution
 */
gulp.task('sass', () => {
    return gulp.src('./web/src/styles/*.scss')
        .pipe(sass(sassDistribution.nodePath).on('error', sass.logError))
        .pipe(autoPrefix(sassDistribution.autoPrefix))
        .pipe(rebaseUrls())
        .pipe(minCss())
        .pipe(gulp.dest(sassDistribution.path));
});

/**
 * Watcher for sass, js and twig files
 */
gulp.task('watch', () => {
    gulp.watch('./web/src/styles/*/*/*.scss', ['sass']);
});

gulp.task('default', ['sass']);
