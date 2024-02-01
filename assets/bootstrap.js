// import { startStimulusApp } from '@symfony/stimulus-bundle';

// const app = startStimulusApp();
// // register any custom, 3rd party controllers here
// // app.register('some_controller_name', SomeImportedController);
Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/bootstrap.js')
    .autoProvidejQuery()
    .enableSingleRuntimeChunk()
    .enableStimulusBridge('./assets/controllers.json') // Check this line
    .splitEntryChunks()
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
;