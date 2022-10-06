Duonghoo - 29/08/2022

***

# Build scss/js to css/min.js
>scss/js in folder resource.
>after code run terminal code to build:
    
    * First type "npm i" to install nodejs
    * When test in local: "npm run dev".
    * When deploy to server: "npm run prod"

## Cách thức cào bài từ nettruyen
- Đã cài thư viện phụ thuộc "mysql2, puppeteer, jsdom, jquery". Chạy ``` npm i ``` ở gốc thư mục
- Truy cập thư mục ./crawler_js
- Với cào theo chuyên mục chạy script ``` node crawler.js {link category} {id category ở database phía mình} {Tùy chọn update lại chapter}``` . Ví dụ ```node .\crawler.js 'https://www.nettruyenme.com/tim-truyen/dam-my' 1 ```
- Với cào theo link truyện chạy script ``` node crawler_one.js {link truyện} {id category ở database phía mình} {Tùy chọn update lại chapter}```. Ví dụ ```node .\crawler_one.js 'https://www.nettruyenme.com/truyen-tranh/canh-kiem-chi-phong-68020' 1 ```