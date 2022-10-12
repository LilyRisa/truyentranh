const puppeteer = require('puppeteer');
const mysql = require("mysql2/promise");
var jsdom = require("jsdom");

require('dotenv').config({path: __dirname+'/../.env'});
const moment = require('moment');                                                                                
var fs = require('fs');
const { v4: uuidv4 } = require('uuid');
const axios = require('axios');

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

let link_story = typeof args[2] == 'undefined' ? null : args[2];
let category_id = typeof args[3] == 'undefined' ? null : args[3];
let update_chapter = typeof args[4] == 'undefined' ? null : args[3];



(async () => {

const CONNECT = await mysql.createConnection(CONFIG);
if(CONNECT){
    console.log('connected database !');
}else{
    return 0;
}

const browser = await puppeteer.launch({
    headless: true,
    args: ['--no-sandbox']
 });
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
                    console.log('Updated url chapter: '+ chap);
                }catch(e){
                    return 0;
                }
                
            }else{
                return 0;
            }
            
        }else{
            try{
                await CONNECT.execute('insert into chapters (title, meta_title, description, meta_description, content, source_origin, created_at, views, update_origin, story_id) values (?,?,?,?,?,?,?,?,?,?)', [
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
    let [rows, fields] = await CONNECT.execute('select id from story where slug_origin = ?', [data.slug_origin]);
    if(rows.length > 0) {
        console.log('Duplicate url: '+ data.title);
        return rows[0].id;
    }
    try{
        let ins = await CONNECT.execute('INSERT INTO story (title, slug, description, meta_title, meta_description, meta_keyword, keyword, thumbnail, name, other_name, status, content, is_home, is_feature, author, views, source_origin, slug_origin, is_update, created_at, main_keyword) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)',
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
            data.author,
            data.views,
            data.source_origin,
            data.slug_origin,
            data.is_update,
            moment().format('YYYY-MM-DD HH:mm:ss'),
            data.main_keyword,
        ]);
        console.log('Tao thanh cong truyen :'+ data.title);
       let [rows] = await CONNECT.execute('SELECT id from story where source_origin = ?', [data.source_origin]);
       // insert category
       try{
            await CONNECT.execute('INSERT INTO story_category (story_id, category_id, is_primary) VALUES (?,?,?)', [
                rows[0].id,
                category_id,
                1
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

    if(thumbnail.length >= 0){
        thumbnail = await movefile(thumbnail[0]);
    }
        
    
    data.data_truyen.title = title;
    data.data_truyen.slug_origin = link_origin;
    data.data_truyen.slug = slugify(title);
    data.data_truyen.description = `✔️ Đọc truyện tranh ${title} Tiếng Việt bản dịch Full mới nhất, ảnh đẹp chất lượng cao, cập nhật nhanh và sớm nhất tại ${process.env.APP_NAME}`;
    data.data_truyen.meta_title = title;
    data.data_truyen.meta_description = `✔️ Đọc truyện tranh ${title} Tiếng Việt bản dịch Full mới nhất, ảnh đẹp chất lượng cao, cập nhật nhanh và sớm nhất tại ${process.env.APP_NAME}`;
    data.data_truyen.meta_keyword = title;
    data.data_truyen.main_keyword = title;
    data.data_truyen.keyword = '';
    data.data_truyen.thumbnail = thumbnail;
    data.data_truyen.name = title;
    data.data_truyen.other_name = title;
    data.data_truyen.status = 1;
    data.data_truyen.content = content;
    data.data_truyen.is_home = 0;
    data.data_truyen.is_feature = 0;
    data.data_truyen.author = author;
    data.data_truyen.source_origin = link;
    data.data_truyen.is_update = is_update;
    data.data_truyen.views = Math.floor(Math.random() * 1000) + 100;
    data.chapter = chapter_list;
    return data;

}


let { data_truyen, chapter } = await get_link_truyen(link_story);
let id_story = await insert_truyen(data_truyen);
await insert_chapter(chapter, id_story);


await browser.close();
console.log('done!');
return 0;
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


    
    async function movefile(url, dest){
        url = 'http:'+url;
    
        var dateObj = new Date();
        var month = dateObj.getUTCMonth() + 1; //months from 1-12
        var year = dateObj.getUTCFullYear();
        let dir_filename = '../public/upload/admin/story/'+year+'/'+month+'/';
    
        let filename = url.split('/');
        filename = filename[filename.length - 1];
        const saveFile = await request(url);
    
        if (!fs.existsSync(dir_filename)){
            fs.mkdirSync(dir_filename, { recursive: true });
        }
        const download = fs.createWriteStream(dir_filename+'/'+filename);
        await new Promise((resolve, reject)=> {
            saveFile.data.pipe(download);
            download.on("close", resolve);
            download.on("error", console.error);
        });
        return '/upload/admin/story/'+year+'/'+month+'/'+filename;
    }
    
    function request (element) {
        try{
          return axios({
            url: element,
            method: "GET",
            responseType: "stream"
          });
        } catch(e) {
          console.log( 'errore: ' + e)
        }
      }