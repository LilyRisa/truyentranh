const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
 var fs = require('fs');

 const CSS_PATH = 'resources/css/';
 const JS_PATH = 'resources/js/';

 var css = fs.readdirSync(CSS_PATH);
 var js = fs.readdirSync(JS_PATH);
 js = js.map((item) => JS_PATH+item)
css.map((item) =>{
    let path = CSS_PATH+item;
    let file = item.split('.');
    ext = file[file.length - 1];
    let filename = file.slice(0, -1);
    filename = filename.join('.')+'.css';
    
    console.log(filename);
    console.log(ext);
    if(ext == 'css'){
        mix.styles(path, 'public/css/'+filename);
    }else{
        mix.sass(path, 'public/css/'+filename);
    }
    
})


mix.js(js, 'public/js/app.js');

