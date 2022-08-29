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

 js = js.map((item) => {
    let path = fs.statSync(JS_PATH+item);
    if(path.isFile()){
        console.log('\x1b[36m%s\x1b[0m','File detected:' + CSS_PATH + item);
        return JS_PATH+item
    }
})

css.map((item) =>{
    let path = fs.statSync(CSS_PATH+item);
    if(path.isFile()){
        console.log('\x1b[36m%s\x1b[0m','File detected:' + CSS_PATH+ item);
        let path = CSS_PATH+item;
        let file = item.split('.');
        ext = file[file.length - 1];
        let filename = file.slice(0, -1);
        filename = filename.join('.')+'.css';
        if(ext == 'css'){
            mix.styles(path, 'public/css/'+filename);
        }else{
            mix.sass(path, 'public/css/'+filename);
        }
    }
    
})


mix.js(js, 'public/js/app.js');

