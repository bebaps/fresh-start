# Fresh Start
A custom build of the [_s](https://github.com/automattic/_s) WordPress starter theme. This theme assumes this is not your first time building a WordPress theme, and that you are familiar with Node, NPM, Gulp, Sass, Babel, etc.

## Why create yet another starter theme?
I created this for my own personal use, and if you happen to find value in it and want to use it yourself then awesome. If not, trust me I won't notice. I looked at every starter theme I could find and there are a lot of good ones, but nothing that was exactly what I needed it to be. If you are reading this then you know exactly what I am talking about. I somehow always came back around to [_s](https://github.com/automattic/_s) or [Sage](https://roots.io/sage/), and finally decided to just pick the one that would be easier to tweak for my own needs.

Frankly, you should probably do the same.

## Why use _s?
- Because it is created by the same people that manage WordPress.com and heavily contribute to WordPress core, so the base theme already adheres to the Theme Review guidelines and agreed upon best practices.
- It is developed in parallel with WordPress core. This is important because it means that the theme will always make use of the newest and most appropriate theme functions for functionality.
- It keeps the custom functionality to a minimum, leaving it up to you to add it.
- It is open source, so it really is a community theme.

## But it ships with shit I don't need or markup I don't agree with
Probably. But that depends on you as a developer. You are meant to really examine the code, understand what it is doing, and hack it to fit your needs. If you are too lazy to do that, then [_s](https://github.com/automattic/_s), this theme, or really any starter theme is not meant for you.

As the default [_s](https://github.com/automattic/_s) theme is meant to be a very broad starting point, I have already stripped this down to what I need it to be. If you agree with my changes, cool, the sooner you can get to work. If not, that's cool too. Change it.

# Getting Started
If you haven't done so already, download [Node](https://nodejs.org/en/) or [read this](https://docs.npmjs.com/getting-started/installing-node). Then clone this repo or download the latest release of this theme, renaming the directory from `fresh-start` to whatever the name of your theme will be. Then follow these steps:

* Search for: `'fresh-start'` and replace with: `'your-theme'`
* Search for: `fresh-start_` and replace with: `your-theme_`
* Search for: `fresh_start_` and replace with: `your_theme_`
* Search for: `Text Domain: fresh-start` and replace with: `Text Domain: your-theme` in style.css.
* Search for: <code>&nbsp;fresh-start</code> and replace with: <code>&nbsp;your-theme</code>
* Search for: `fresh-start-` and replace with: `your-theme-`

Next, update the stylesheet header in `style.css` and the links in `footer.php` with your own information.

Run `npm install` or `yarn install` (you may need to run with `sudo` depending on your set up) to install all of the dependencies for the theme.

Finally, you should change both the `localURL` and `project` constants found in `gulpfile.babel.js` on lines 4 and 7 to match your environment and theme. Once that is complete, run `gulp` to run all the default tasks and get to work.

## Theme Customization
If you look at most the template files in the theme root, most of them just load template parts as needed. This is because there is really only so much you can do with the WordPress template hierarchy, and really I don't want to edit these files at all if I don't need too. So all of the customizations should take place in the `/templates` folder.

In this folder is where all of any custom markup should live.

## Tools
A few of the core tools used to put this theme together are listed below. If you have never heard of them or just don't know how to use them, take the time to review the documentation for each. The uses of each expand far beyond WordPress development and can surely benefit you in all areas of web development.

### Gulp
This theme uses [Gulp](http://gulpjs.com/). Be sure to actually review this themes `gulpfile.babel.js` to understand what the tasks are doing and in what order. Use my tasks or create your own.

#### gulp-load-plugins
This Gulp package makes it really easy to include the Gulp packages for use in your gulpfile. If you look through this themes `gulpfile.babel.js` and stuff like `$.plumber()` doesn't make sense to you, read [this](https://www.npmjs.com/package/gulp-load-plugins).

### Babel
[Babel](https://babeljs.io/) is included for those that what to use it, but by default I have commented out its use (line 179). Uncomment that line or write your own task for it.

### Sass
[Sass](http://sass-lang.com/guide) is my CSS preprocessor of choice. If you use Less or Stylus then you will need to install and write your own tasks for them.

### Editor Config
The [Editor Config](http://editorconfig.org/) is really just for portability. Be sure to configure this how you like so that regardless of what editor you use (or computer), your project is always formatted the same.

### ESLint
[ESLint](http://eslint.org/) offers a ton of settings to check the style and quality of your JavaScript code. If you don't use it, take the time to review it because it really will force you to write better code. Use my default settings found in `.eslintrc.json` or create your own.

### Stylelint
[Stylelint](http://stylelint.io/) is the same idea as ESLint, but for your CSS. Use my default settings found in `.stylelintrc` or create your own.

## Extras
Take note of two files in the `inc/` directory: `theme-functions.php` and `theme-extras.php`. Be sure to review these files to understand what they are doing.

### theme-functions.php
This file holds a few custom functions I use frequently. Add your own to this file.

### theme-extras.php
This file contains a small amount of tweaks I find useful for themes. As these are purely my opinion, modify this as you see fit or delete this file.
