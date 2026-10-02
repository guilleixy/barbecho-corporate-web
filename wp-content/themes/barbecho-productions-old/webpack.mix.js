
let mix = require('laravel-mix');

mix
  .js('src/app.js', '')
  .sass('src/app.scss', '', {
    sassOptions: {
      outputStyle: 'nested'
    }
  })
  .setPublicPath('dist');
