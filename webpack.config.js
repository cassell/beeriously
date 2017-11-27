var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(true)
    .addEntry('js/app', './public/assets/js/app.js')
    .addStyleEntry('css/app', './public/assets/css/app.scss')
    .enableSassLoader(function(sassOptions) {}, {
                 resolveUrlLoader: false
     })
    .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
