# Laravel 11 豐富的 JavaScript 產生網站內容上抓取連結

網站內容動態地以 Javascript 呈現出來，因此雖然在瀏覽器上看到，但下載回來的 HTML 檔卻不會含有資料，要解決這個問題需要能夠先運行 Javascript 程式，畢竟 JavaScript 為使用者帶來更良好的體驗及使用，為了讓 JavaScript 內容被爬取、渲染並且索引，耗費的資源是一般 HTML 頁面的 20 倍，一定要格外小心。

## 使用方式
- 把整個專案複製一份到你的電腦裡，這裡指的「內容」不是只有檔案，而是指所有整個專案的歷史紀錄、分支、標籤等內容都會複製一份下來。
```sh
$ git clone
```
- 將 __.env.example__ 檔案重新命名成 __.env__，如果應用程式金鑰沒有被設定的話，你的使用者 sessions 和其他加密的資料都是不安全的！
- 當你的專案中已經有 composer.lock，可以直接執行指令以讓 Composer 安裝 composer.lock 中指定的套件及版本。
```sh
$ composer install
```
- 產生 Laravel 要使用的一組 32 字元長度的隨機字串 APP_KEY 並存在 .env 內。
```sh
$ php artisan key:generate
```
- 執行 __Artisan__ 指令的 __migrate__ 來執行所有未完成的遷移。
```sh
$ php artisan migrate
```
- 執行安裝 Vite 和 Laravel 擴充套件引用的依賴項目。
```sh
$ npm install
```
- 執行正式環境版本化資源管道並編譯。
```sh
$ npm run build
```
- 執行 __Artisan__ 指令的 __crawl:books__ 來執行抓取博客來網站的連結。
```sh
$ php artisan crawl:books
```

----

## 畫面截圖
![](https://i.imgur.com/d7M5nd0.png)
> 開始搜尋特定的已知網頁組合，然後再跟隨該等網頁的超連結，存取其他網頁、接著再跟隨其他網頁的超連結，存取更多網頁，據此不斷進行此作業
