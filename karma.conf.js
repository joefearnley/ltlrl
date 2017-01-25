module.exports = function(config) {
    config.set({
        basePath: '',
        frameworks: ['jasmine'],
        files: [
            'public/js/lib.js',
            'node_modules/angular-mocks/angular-mocks.js',
            'resources/assets/js/app/app.js',
            'resources/assets/js/app/controllers/home.controller.js',
            //'resources/assets/js/app/services/*.js',
            'resources/assets/js/tests/*.js'
        ],
        exclude: [],
        preprocessors: {},
        reporters: ['spec'],
        port: 9876,
        colors: true,
        logLevel: config.LOG_INFO,
        autoWatch: true,
        browsers: ['PhantomJS'],
        singleRun: true,
        concurrency: Infinity
    });
};
