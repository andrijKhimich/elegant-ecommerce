import gulp from 'gulp';
import browserSync from 'browser-sync';
import { deleteAsync } from 'del';
import newer from 'gulp-newer';
import ifPlugin from 'gulp-if';
import mergeStream from 'merge-stream';
import fileinclude from 'gulp-file-include';
import * as dartSass from 'sass';
import gulpSass from 'gulp-sass';
import rename from 'gulp-rename';
import GulpCleanCss from 'gulp-clean-css';
import autoPrefixer from 'gulp-autoprefixer';
import gulpGroupCssMediaQueries from 'gulp-group-css-media-queries';
import sourcemaps from 'gulp-sourcemaps';
import webpack from 'webpack-stream';
import babel from 'gulp-babel';
import webp from 'gulp-webp';
import imagemin from 'gulp-imagemin';
import gulpSVGSprite from 'gulp-svg-sprite';
import gulpCheerio from 'gulp-cheerio';
import fonter from 'gulp-fonter-fix';
import ttf2woff2 from 'gulp-ttf2woff2';

const deployFolder = 'build';
const devFolder = 'dev';

const path = {
	build: {
		html: `${deployFolder}/`,
		scss: `${deployFolder}/css/`,
		js: `${deployFolder}/js/`,
		images: `${deployFolder}/images/`,
		sprite: `${deployFolder}/images/sprite`,
		fonts: `${deployFolder}/fonts/`,
		files: `${deployFolder}/files/`,
	},
	dev: {
		html: `${devFolder}/*.html`,
		scss: `${devFolder}/scss/style.scss`,
		js: `${devFolder}/js/**/*.js`,
		images: `${devFolder}/images/**/*.{jpg,png,gif,ico,webp,svg}`,
		sprite: `${devFolder}/images/sprite/*.svg`,
		svg: `${deployFolder}/images/**/*.svg`,
		fonts: `${devFolder}/fonts/**/*.ttf`,
		files: `${devFolder}/files/**/*.*`,
	},
	watch: {
		html: `${devFolder}/**/*.html`,
		scss: `${devFolder}/scss/**/*.scss`,
		js: `${devFolder}/js/**/*.js`,
		images: `${devFolder}/images/**/*.{jpg,png,svg,gif,ico,webp,svg}`,
		sprite: `${devFolder}/images/sprite/*.svg`,
		files: `${devFolder}/files/**/*.*`,
	},
	clean: `./${deployFolder}/`,
};

global.app = {
	isBuild: process.argv.includes('--build'),
	isDev: !process.argv.includes('--build'),
};

const server = () => {
	browserSync.init({
		server: {
			baseDir: `./${deployFolder}/`,
		},
		port: 3000,
		notify: true,
	});
};

const html = () => {
	return gulp
		.src(path.dev.html)
		.pipe(fileinclude())
		.pipe(gulp.dest(path.build.html))
		.pipe(browserSync.stream());
};

const files = () => {
	return gulp.src(path.dev.files).pipe(gulp.dest(path.build.files));
};

export const reset = () => {
	return deleteAsync(path.clean);
};

const sass = gulpSass(dartSass);

const scss = () => {
	return gulp
		.src(path.dev.scss)
		.pipe(ifPlugin(app.isDev, sourcemaps.init()))
		.pipe(sass({ outputStyle: 'expanded' }))
		.pipe(gulpGroupCssMediaQueries())
		.pipe(
			autoPrefixer({
				grid: true,
				overrideBrowserslist: ['last 3 versions'],
				cascade: true,
			})
		)
		.pipe(gulp.dest(path.build.scss))
		.pipe(GulpCleanCss())
		.pipe(rename({ extname: '.min.css' }))
		.pipe(ifPlugin(app.isDev, sourcemaps.write('../css')))
		.pipe(gulp.dest(path.build.scss))
		.pipe(browserSync.stream());
};

const js = () => {
	const processScript = (entry, output) => {
		return gulp
			.src(path.dev.js)
			.pipe(
				babel({
					presets: ['@babel/env'],
				})
			)
			.pipe(
				webpack({
					mode: app.isBuild ? 'production' : 'development',
					entry: entry,
					resolve: {
						extensions: ['.js'],
					},
					output: {
						filename: output,
					},
				})
			)
			.pipe(gulp.dest(path.build.js));
	};

	return mergeStream(
		processScript('./dev/js/script.js', 'script.min.js'),
		processScript('./dev/js/libs.js', 'libs.min.js')
	).pipe(browserSync.stream());
};

const images = () => {
	return gulp
		.src(path.dev.images)
		.pipe(newer(path.build.images))
		.pipe(ifPlugin(app.isDev, webp()))
		.pipe(ifPlugin(app.isDev, gulp.dest(path.build.images)))
		.pipe(ifPlugin(app.isDev, gulp.src(path.dev.images)))
		.pipe(ifPlugin(app.isDev, newer(path.build.images)))
		.pipe(
			ifPlugin(
				app.isBuild,
				imagemin({
					progressive: true,
					svgoPlugins: [{ removeViewBox: false }],
					interlaced: true,
					optimizationLevel: 7, //to 7
				})
			)
		)
		.pipe(gulp.dest(path.build.images))
		.pipe(browserSync.stream());
};

const spriteSvg = () => {
	return gulp
		.src(path.dev.sprite, {})
		.pipe(
			gulpSVGSprite({
				mode: {
					stack: {
						sprite: '../sprite.svg',
						example: false,
					},
				},
			})
		)
		.pipe(
			gulpCheerio({
				run: function ($) {
					$('[fill]').removeAttr('fill');
					$('[stroke]').removeAttr('stroke');
					$('[style]').removeAttr('style');
					$('[class]').removeAttr('class');
					$('[width]').removeAttr('width');
					$('[height]').removeAttr('height');
					$('style').remove();
				},
				parserOptions: {
					xmlMode: true,
				},
			})
		)
		.pipe(gulp.dest(path.build.sprite));
};

const otfToTtf = () => {
	return gulp
		.src(`${path.dev.fonts}/*.otf`, {})
		.pipe(
			fonter({
				formats: ['ttf'],
			})
		)
		.pipe(gulp.dest(path.dev.fonts));
};

const ttfToWoff = () => {
	return gulp
		.src(path.dev.fonts)
		.pipe(
			fonter({
				formats: ['woff'],
			})
		)
		.pipe(gulp.dest(path.build.fonts))
		.pipe(gulp.src(path.dev.fonts))
		.pipe(ttf2woff2())
		.pipe(gulp.dest(path.build.fonts))
		.pipe(gulp.src(`${path.dev.fonts}/*.woff`))
		.pipe(gulp.dest(path.build.fonts))
		.pipe(gulp.src(`${path.dev.fonts}/*.woff2`))
		.pipe(gulp.dest(path.build.fonts));
};

const watchFiles = () => {
	gulp.watch([path.watch.html], html);
	gulp.watch([path.watch.scss], scss);
	gulp.watch([path.watch.js], js);
	gulp.watch([path.watch.images], images);
	gulp.watch([path.watch.sprite], spriteSvg);
	gulp.watch([path.watch.files], files);
};

export { otfToTtf };
const mainTasks = gulp.parallel(files, html, scss, js, images, spriteSvg, ttfToWoff);

const dev = gulp.series(reset, mainTasks, gulp.parallel(watchFiles, server));
const build = gulp.series(reset, mainTasks);
const serve = gulp.series(server);

export { dev, build, serve };

gulp.task('default', dev);
