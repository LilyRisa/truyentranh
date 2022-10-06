const puppeteer = require('puppeteer');
const mysql = require("mysql2/promise");
var jsdom = require("jsdom");

require('dotenv').config({path: __dirname+'/../.env'});
const moment = require('moment');

const CONFIG = {
    host: process.env.DB_HOST,
    user: process.env.DB_USERNAME,
    password: process.env.DB_USERNAME,
    database: process.env.DB_DATABASE
  };



/**
 * argument
 * command: node crawler.js '{link category} {id category local} {update lại chapter}'
 */




const args = process.argv;

let link_tales = typeof args[2] == 'undefined' ? null : args[2];
let category_id = typeof args[3] == 'undefined' ? null : args[3];
let update_chapter = typeof args[4] == 'undefined' ? null : args[3];



(async () => {

const CONNECT = await mysql.createConnection(CONFIG);
if(CONNECT){
    console.log('connected database !');
}else{
    return 0;
}

const browser = await puppeteer.launch();
const page = await browser.newPage();
await page.setUserAgent('Mozilla/5.0 (Windows NT 5.1; rv:5.0) Gecko/20100101 Firefox/5.0');



const insert_chapter = async (chapter, id) => {
    for(let chap of chapter){
        await page.goto(chap);
        
        const html = await page.evaluate(() => document.querySelector('.reading-detail').outerHTML);
        const title = await page.evaluate(() => document.querySelector('.txt-primary span').outerText);
        const title_other  = await page.evaluate(() => document.querySelector('.txt-primary a').outerText);
        // let update = await page.evaluate(() => document.querySelector('.reading .top i').outerText);
        // update = update.split(':');
        // update = update[update.length - 1];
        // console.log(update);
        // update = moment(update).format('YYYY-MM-DD HH:mm:ss');
        
        let dom = new jsdom.JSDOM(html);
        let jquery = require("jquery")(dom.window);
        jquery("#page_0").remove();
        let content = dom.window.document.querySelector(".reading-detail").outerHTML;
        // content = content.textContent;

        //check chapter dulicate 
        let [rows, fields] = await CONNECT.execute('select * from chapters where source_origin = ?', [chap]);

        if(rows.length > 0) {
            console.log('Duplicate url chapter: '+ chap);
            if(update_chapter){
                try{
                    await CONNECT.execute('UPDATE chapters SET content=?, update_origin=?', [
                        content,
                        moment().format('YYYY-MM-DD HH:mm:ss')
                    ]);
                }catch(e){
                    return 0;
                }
                
            }else{
                return 0;
            }
            
        }else{
            try{
                await CONNECT.execute('insert into chapters (title, meta_title, description, meta_description, content, source_origin, created_at, views, update_origin, tales_id) values (?,?,?,?,?,?,?,?,?,?)', [
                    title_other+title,
                    title_other+title,
                    `✔️ Đọc truyện tranh ${title_other+title} Tiếng Việt bản đẹp chất lượng cao, cập nhật nhanh và sớm nhất ${process.env.APP_NAME}`,
                    `✔️ Đọc truyện tranh ${title_other+title} Tiếng Việt bản đẹp chất lượng cao, cập nhật nhanh và sớm nhất ${process.env.APP_NAME}`,
                    content,
                    chap,
                    moment().format('YYYY-MM-DD HH:mm:ss'),
                    Math.floor(Math.random() * 1000) + 100,
                    moment().format('YYYY-MM-DD HH:mm:ss'),
                    id
                ]);
                console.log('Tao thanh cong chapter:'+title_other+title);
            }catch(e){
                console.log(e);
                return 0;
            }
            
        }
    }
}

const insert_truyen = async (data) => {
    let [rows, fields] = await CONNECT.execute('select id from tales where slug_origin = ?', [data.slug_origin]);
    if(rows.length > 0) {
        console.log('Duplicate url: '+ data.title);
        return rows[0].id;
    }
    try{
        let ins = await CONNECT.execute('INSERT INTO tales (title, slug, description, meta_title, meta_description, meta_keyword, keyword, thumbnail, name, other_name, status, content, is_home, is_feature, category_primary_id, author, views, source_origin, slug_origin, is_update, created_at) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
        [
            data.title,
            data.slug,
            data.description,
            data.meta_title,
            data.meta_description,
            data.meta_keyword,
            data.keyword,
            data.thumbnail,
            data.name,
            data.other_name,
            data.status,
            data.content,
            data.is_home,
            data.is_feature,
            data.category_primary_id,
            data.author,
            data.views,
            data.source_origin,
            data.slug_origin,
            data.is_update,
            moment().format('YYYY-MM-DD HH:mm:ss'),
        ]);
        console.log('Tao thanh cong truyen :'+ data.title);
       let [rows] = await CONNECT.execute('SELECT id from tales where source_origin = ?', [data.source_origin]);
       // insert category
       try{
            await CONNECT.execute('INSERT INTO tales_categories (tales_id, category_id, is_primary, created_at) VALUES (?,?,?,?)', [
                rows[0].id,
                category_id,
                1,
                moment().format('YYYY-MM-DD HH:mm:ss'),
            ]);
       }catch(e){
        console.log('khong the tạo category\n');
        console.log(e);
       }
       
       return rows[0].id;
    }catch(error){
        console.log('Khong the tao: '+ data.title);
        console.log(error);
        return 0;
    }
}

const get_link_truyen = async (link) => {
    
    await page.goto(link);
    let link_origin = link.split('/');
    link_origin = link_origin[link_origin.length - 1];
    let data = {
        data_truyen: {},
        chapter: {}
    };

    const title = await page.evaluate(() => document.querySelector('.title-detail').outerText);
    const content = await page.evaluate(() => document.querySelector('.detail-content p').outerText);
    const author = await page.evaluate(() => document.querySelector('.author p.col-xs-8').outerText);
    const is_update = await page.evaluate(() => document.querySelector('.status p.col-xs-8').outerText);

    const chapter_list = await page.evaluate(() => Array.from(document.querySelectorAll('#nt_listchapter .chapter a[href]'), a => a.getAttribute('href')) );
    let thumbnail = await page.$$eval('.detail-info .col-image img[src]', imgs => imgs.map(img => img.getAttribute('src')));

    if(thumbnail.length >= 0)
        thumbnail = thumbnail[0];
    
    data.data_truyen.title = title;
    data.data_truyen.slug_origin = link_origin;
    data.data_truyen.slug = slugify(title);
    data.data_truyen.description = `✔️ Đọc truyện tranh ${title} Tiếng Việt bản dịch Full mới nhất, ảnh đẹp chất lượng cao, cập nhật nhanh và sớm nhất tại ${process.env.APP_NAME}`;
    data.data_truyen.meta_title = title;
    data.data_truyen.meta_description = `✔️ Đọc truyện tranh ${title} Tiếng Việt bản dịch Full mới nhất, ảnh đẹp chất lượng cao, cập nhật nhanh và sớm nhất tại ${process.env.APP_NAME}`;
    data.data_truyen.meta_keyword = '';
    data.data_truyen.keyword = '';
    data.data_truyen.thumbnail = thumbnail;
    data.data_truyen.name = title;
    data.data_truyen.other_name = title;
    data.data_truyen.status = 1;
    data.data_truyen.content = content;
    data.data_truyen.is_home = 0;
    data.data_truyen.is_feature = 0;
    data.data_truyen.category_primary_id = category_id;
    data.data_truyen.author = author;
    data.data_truyen.source_origin = link;
    data.data_truyen.is_update = is_update;
    data.data_truyen.views = Math.floor(Math.random() * 1000) + 100;
    data.chapter = chapter_list;
    return data;

}


let { data_truyen, chapter } = await get_link_truyen(link_tales);
let id_tales = await insert_truyen(data_truyen);
await insert_chapter(chapter, id_tales);


await browser.close();
})();


function slugify(string){
    const a = 'àáäâãåăæąçćčđďèéěėëêęğǵḧìíïîįłḿǹńňñòóöôœøṕŕřßşśšșťțùúüûǘůűūųẃẍÿýźžż·/_,:;'
    const b = 'aaaaaaaaacccddeeeeeeegghiiiiilmnnnnooooooprrsssssttuuuuuuuuuwxyyzzz------'
    const p = new RegExp(a.split('').join('|'), 'g')
    return string.toString().toLowerCase()
        .replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a')
        .replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e')
        .replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i')
        .replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o')
        .replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u')
        .replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y')
        .replace(/đ/gi, 'd')
        .replace(/\s+/g, '-') 
        .replace(p, c => b.charAt(a.indexOf(c)))
        .replace(/&/g, '-and-')
        .replace(/[^\w\-]+/g, '')
        .replace(/\-\-+/g, '-')
        .replace(/^-+/, '')
        .replace(/-+$/, '')
    }