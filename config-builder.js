var upath = require('upath');
var path = require('path');
var Encore = require('@symfony/webpack-encore');

var build = (name, assetPath, vendorUiPath) => {
  Encore
    // the project directory where compiled assets will be stored
    .setOutputPath(`public/assets/${name}`)
    // the public path used by the web server to access the previous directory
    .setPublicPath(`/assets/${name}`)
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    // uncomment to define the assets of the project
    .addEntry('app', `${assetPath}/js/app.js`)
    // uncomment if you use Sass/SCSS files


    .autoProvidejQuery()
    .configureBabel()
    .disableSingleRuntimeChunk()
    .copyFiles({
      from: `${assetPath}/images`,
      to: 'images/[path][name].[ext]',
    }, {
      from: upath.joinSafe(vendorUiPath, 'Resources/private/images'),
      to: 'images/[path][name].[ext]',
    })
    .configureFilenames({
      js: 'js/[name].[hash:8].js',
      css: 'css/[name].[hash:8].css',
    })
    .configureImageRule({
      filename: 'images/[name].[hash:8].[ext]',
    })
    .configureFontRule({
      filename: 'font/[name].[hash:8].[ext]'
    })

  ;

  if (name === 'backend') {
    Encore.enableSassLoader((options) => {
      options.additionalData = '@import "~semantic-ui-css/semantic.min.css";';
    });
  }

  if (name === 'frontend') {
    Encore.enablePostCssLoader();
    Encore.enableSassLoader();
  }

  const config = Encore.getWebpackConfig();
  config.name = name;
  config.resolve.alias = {
    '~': path.resolve(__dirname, '../../'),
    'sylius/ui': vendorUiPath + '/Resources/private',
  };

  Encore.reset();

  return config;
};

module.exports = build;
