var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableVersioning(false)
    .enableSourceMaps(false)
    .addEntry('js/app', './assets/js/app.js')
    .addStyleEntry('css/app', './assets/css/app.scss')
    .enableSassLoader()
    .autoProvidejQuery()
;

var config = Encore.getWebpackConfig();

// config.watchOptions = { poll: true, ignored: /node_modules/ };
// config.resolve.alias.local = path.resolve(__dirname, './resources/src');
// config.resolve.extensions.push('json');

// export the final config
module.exports = config;
