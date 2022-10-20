<?php

use Illuminate\Support\Facades\Route;
use App\Models\Rate;
use App\Models\ShortCode;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;

function toSlug($doc)
{
    $str = addslashes(html_entity_decode($doc));
    $str = trim($str);
    $str = toNormal($str);
    $str = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
    $str = preg_replace("/( )/", '-', $str);
    $str = str_replace('/', '', $str);
    $str = str_replace("\/", '', $str);
    $str = str_replace("+", "", $str);
    $str = strtolower($str);
    $str = stripslashes($str);
    return trim($str, '-');
}

function toNormal($str)
{
    $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
    $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
    $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
    $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
    $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
    $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
    $str = preg_replace("/(đ)/", 'd', $str);
    $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
    $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
    $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
    $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
    $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
    $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
    $str = preg_replace("/(Đ)/", 'D', $str);
    return $str;
}

function strip_quotes($str)
{
    return str_replace(array('"', "'"), '', $str);
}

function get_limit_content($string, $length = 255)
{
    $string = strip_tags($string);
    if (strlen($string) > 0) {
        $arr = explode(' ', $string);
        $return = '';
        if (count($arr) > 0) {
            $count = 0;
            if ($arr) foreach ($arr as $str) {
                $count += strlen($str);
                if ($count > $length) {
                    $return .= "...";
                    break;
                }
                $return .= " " . $str;
            }
            $return = closeTags($return);
        }
        return $return;
    } else {
        return '';
    }
}

function closeTags($html){
    preg_match_all('#<(?!meta|img|br|hr|input\b)\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
    $openEdTags = $result[1];
    preg_match_all('#</([a-z]+)>#iU', $html, $result);
    $closedTags = $result[1];
    $len_opened = count($openEdTags);
    if (count($closedTags) == $len_opened) {
        return $html;
    }
    $openEdTags = array_reverse($openEdTags);
    for ($i = 0; $i < $len_opened; $i++) {
        if (!in_array($openEdTags[$i], $closedTags)) {
            $html .= '</' . $openEdTags[$i] . '>';
        } else {
            unset($closedTags[array_search($openEdTags[$i], $closedTags)]);
        }
    }
    return $html;
}
if (!function_exists('truncate_html')){
    function truncate_html ($string, $limit, $break=" ", $pad="") {
       // return with no change if string is shorter than $limit
        if(strlen($string) <= $limit) return $string;

        $string = substr($string, 0, $limit);
        if(false !== ($breakpoint = strrpos($string, $break))) {
            $string = substr($string, 0, $breakpoint);
        }

        return restoreTags($string) . $pad;
    }
}

if (!function_exists('restoreTags')){
    function restoreTags($input)
    {
        $opened = array();

        // loop through opened and closed tags in order
        if(preg_match_all("/<(\/?[a-z]+)>?/i", $input, $matches)) {
        foreach($matches[1] as $tag) {
            if(preg_match("/^[a-z]+$/i", $tag, $regs)) {
            // a tag has been opened
            if(strtolower($regs[0]) != 'br') $opened[] = $regs[0];
            } elseif(preg_match("/^\/([a-z]+)$/i", $tag, $regs)) {
            // a tag has been closed
            $key = array_keys($opened, $regs[1]);
            $key = array_pop($key);
            unset($opened[$key]);
            }
        }
        }

        // close tags that are still open
        if($opened) {
        $tagstoclose = array_reverse($opened);
        foreach($tagstoclose as $tag) $input .= "</$tag>";
        }

        return $input;
  }
}

function getListPermission() {
    return [
        'category' => 'Chuyên mục',
        'post' => 'Bài viết',
        'page' => 'Page tĩnh',
        'tag' => 'Tag',
        'user' => 'Thành viên',
        'group' => 'Nhóm quyền',
        'site_setting' => 'Cài đặt chung',
        'redirect' => 'Cấu hình Redirect',
        'menu' => 'Cấu hình Menu',
        // 'banner' => 'Banner',
        'categoryauthor' => 'Tác giả chuyên mục',
        // 'video' => 'Video',
        'shortcode' => 'short code',
        'internallink' => 'Internal link',
        'googleindex' => 'gooogle index',
        'story' => 'Truyện',
        'chapter' => 'Chương truyện'
    ];
}


function getCurrentController() {
    $controller = class_basename(Route::current()->controller);
    return strtolower(str_replace('Controller', '', $controller));
}

function getCurrentAction() {
    return class_basename(Route::current()->getActionMethod());
}

function getCurrentParams() {
    return Route::current()->parameters();
}

function getCurrentControllerTitle() {
    $controller = getCurrentController();
    $listPermission = getListPermission();
    return !empty($listPermission[$controller]) ? $listPermission[$controller] : '';
}

function getSiteSetting($key) {
    $value = '';
    if (!empty($key)) {
        if(Cache::has('getSiteSetting-'.$key)){
            $value = Cache::get('getSiteSetting-'.$key);
        }else{
            $value = \App\Models\SiteSetting::where('setting_key', $key)->first();
            Cache::set('getSiteSetting-'.$key, $value, now()->addHours(24));
        }

    }
    if(empty($value)) return null;
    return $value->setting_value;
}
function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

function genImage($src, $width, $height, $class = 'img-fluid',  $title = false, $lazy = true) {
    if ($lazy)
        $lazy = " loading=\"lazy\"";
    $src = getThumbnail($src, $width, $height);
    $img = "<img $lazy src='$src' alt='$title' class='$class' width='$width' height='$height'>";

return $img;
}

function turnOnAjaxAmp(){
header("Content-type: application/json");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Origin: https://thichdammy-com.cdn.ampproject.org");
header("AMP-Access-Control-Allow-Source-Origin: ". URL::to('/'));
header("Access-Control-Expose-Headers: AMP-Access-Control-Allow-Source-Origin");
}

function getThumbnail($image_url, $width = '', $height = ''){

$source_file = public_path().$image_url;


if(Config::get('app.env') == 'local'){
    return Config::get('app.url').$image_url;
}

if (!file_exists($source_file)){
    return $image_url;
}

//return url($image_url);
//check file exist
if (empty($width) || empty($height))
    return url($image_url);

$source_file = str_replace('//','/',$source_file);

$image_name = substr($image_url, 0, strrpos($image_url, '.'));
$image_ext = substr($image_url, strrpos($image_url, '.'));

$resize_image_name = $image_name.'-'.$width.'x'.$height.$image_ext;
$resize_image_file = public_path().'/thumb'.$resize_image_name;
$resize_image_url = url('thumb'.$resize_image_name);

if(file_exists($resize_image_file)){
    $img_src = $resize_image_url;
}else{
    resize_crop_image($width, $height, $source_file, $resize_image_file);
    if(file_exists($resize_image_file)){
        $img_src = $resize_image_url;
    }else{
        $img_src = $image_url;
    }
}

return $img_src;
}

function resize_crop_image($max_width, $max_height, $source_file, $dst_dir, $quality = 80){
try {
    $imgSize = getimagesize($source_file);
    $width = $imgSize[0];
    $height = $imgSize[1];
    $mime = $imgSize['mime'];

    switch ($mime) {
        case 'image/gif':
            $image_create = "imagecreatefromgif";
            $image = "imagegif";
            break;

        case 'image/png':
            $image_create = "imagecreatefrompng";
            $image = "imagepng";
            $quality = 7;
            break;

        case 'image/jpeg':
            $image_create = "imagecreatefromjpeg";
            $image = "imagejpeg";
            $quality = 80;
            break;

        default:
            return false;
            break;
    }

    $dst_img = imagecreatetruecolor($max_width, $max_height);
    $src_img = $image_create($source_file);

    $width_new = $height * $max_width / $max_height;
    $height_new = $width * $max_height / $max_width;
    //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
    if ($width_new > $width) {
        //cut point by height
        $h_point = (($height - $height_new) / 2);
        //copy image
        imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
    } else {
        //cut point by width
        $w_point = (($width - $width_new) / 2);
        imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
    }

    $folderPath = substr($dst_dir, 0, strrpos($dst_dir, '/'));
    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0755, true);
    }

    $image($dst_img, $dst_dir, $quality);

    if ($dst_img) imagedestroy($dst_img);
    if ($src_img) imagedestroy($src_img);
} catch (Exception $e) {

}
}

function content_rss_replace($content){
    $content = preg_replace('/[\x00-\x09\x0B\x0C\x0E-\x1F\x7F]/', '', $content);
    $content = preg_replace("/\<iframe.*?\>.*?\<\/iframe\>/", "", $content);
    $content = preg_replace("/caption\=['\"].*?['\"]/", "", $content);
    $content = preg_replace("/controls\=['\"].*?['\"]/", "", $content);
    return $content;
}

function initSeoData($item='', $type='home'){
switch ($type) {
    case 'category':
        $data_seo = [
            'meta_title' => strip_quotes($item->meta_title),
            'meta_keyword' => $item->meta_keyword,
            'meta_description' => strip_quotes($item->meta_description),
            'site_image' => $item->thumbnail,
            'canonical' => getUrlCate($item, false, true),
            'amphtml' => getUrlCate($item, 1),
            'index' => !empty($item->status) ? 'index,follow' : 'noindex,nofollow',
        ];
        break;
    case 'tag':
        $data_seo = [
            'meta_title' => strip_quotes($item->meta_title),
            'meta_keyword' => $item->meta_keyword,
            'meta_description' => strip_quotes($item->meta_description),
            'site_image' => getSiteSetting('site_logo'),
            'canonical' => getUrlTag($item, false, true),
            'amphtml' => getUrlTag($item, 1),
            'index' => !empty($item->index) ? 'index,follow' : 'noindex,nofollow',
        ];
        break;
    case 'page':
        $data_seo = [
            'meta_title' => strip_quotes($item->meta_title),
            'meta_keyword' => $item->meta_keyword,
            'meta_description' => strip_quotes($item->meta_description),
            'site_image' => $item->thumbnail,
            'canonical' => getUrlStaticPage($item, false, true),
            'amphtml' => getUrlStaticPage($item, 1),
            'index' => !empty($item->status) ? 'index,follow' : 'noindex,nofollow',
            'published_time' => !empty($item->displayed_time) ? date('Y-m-d\TH:i:s',strtotime($item->displayed_time) - 1800) : '',
            'modified_time' => !empty($item->displayed_time) ? date('Y-m-d\TH:i:s',strtotime($item->displayed_time)) : '',
            'updated_time' => !empty($item->displayed_time) ? date('Y-m-d\TH:i:s',strtotime($item->displayed_time)) :''
        ];
        if(!$item->is_amp){
            unset($data_seo['amphtml']);
            unset($data_seo['canonical']);
        }
        break;
    case 'page-static':
        $data_seo = [
            'meta_title' => strip_quotes($item->meta_title),
            'meta_keyword' => $item->meta_keyword,
            'meta_description' => strip_quotes($item->meta_description),
            'site_image' => $item->thumbnail,
            // 'canonical' => getUrlStaticPage($item, false, true),
            // 'amphtml' => getUrlStaticPage($item, 1),
            'index' => !empty($item->status) ? 'index,follow' : 'noindex,nofollow',
            'published_time' => !empty($item->displayed_time) ? date('Y-m-d\TH:i:s',strtotime($item->displayed_time) - 1800) : '',
            'modified_time' => !empty($item->displayed_time) ? date('Y-m-d\TH:i:s',strtotime($item->displayed_time)) : '',
            'updated_time' => !empty($item->displayed_time) ? date('Y-m-d\TH:i:s',strtotime($item->displayed_time)) :''
        ];
        if($item->canonical){
            $data_seo['canonical'] = getUrlStaticPage($item, false, true);
        }
        if($item->amphtml){
            $data_seo['amphtml'] = getUrlStaticPage($item, 1);
        }
        
        break;
    case 'post':
        $data_seo = [
            'meta_title' => strip_quotes($item->meta_title),
            'meta_keyword' => $item->meta_keyword,
            'meta_description' => strip_quotes($item->meta_description),
            'site_image' => $item->thumbnail,
            'canonical' => getUrlPost($item, false, true),
            'amphtml' => getUrlPost($item, 1),
            'index' => 'index,follow',
            'published_time' => !empty($item->displayed_time) ? date('Y-m-d\TH:i:s',strtotime($item->displayed_time) - 1800) : '',
            'modified_time' => !empty($item->displayed_time) ? date('Y-m-d\TH:i:s',strtotime($item->displayed_time)) : '',
            'updated_time' => !empty($item->displayed_time) ? date('Y-m-d\TH:i:s',strtotime($item->displayed_time)) :''
        ];
        break;
    case 'home':
        $data_seo = [
            'meta_title' => strip_quotes(getSiteSetting('site_title')),
            'meta_keyword' => strip_quotes(getSiteSetting('site_keyword')),
            'meta_description' => strip_quotes(getSiteSetting('site_description')),
            'site_image' => env('SITE_LOGO'),
            'canonical' => str_replace('/amp', '', url()->current()),
            'amphtml' => url(Request::getRequestUri()).'/amp/',
            'index' => 'index,follow',
            'published_time' => '',
            'modified_time' => '',
            'updated_time' => ''
        ];
        break;
    case 'author':
        $data_seo = [
            'meta_title' => 'Tác giả '.strip_quotes($item->fullname),
            'meta_keyword' => 'tac gia',
            'meta_description' => strip_quotes(strip_tags($item->description)),
            'site_image' => env('SITE_LOGO'),
            'canonical' => str_replace('/amp', '', url()->current()),
            // 'amphtml' => url(Request::getRequestUri()).'/amp/',
            'index' => 'index,follow',
            'published_time' => '',
            'modified_time' => '',
            'updated_time' => ''
        ];
        break;
    default:
        $data_seo = [
            'meta_title' => strip_quotes(getSiteSetting('site_title')),
            'meta_keyword' => '',
            'meta_description' => strip_quotes(getSiteSetting('site_description')),
            'site_image' => env('SITE_LOGO'),
            'canonical' => url()->current(),
            'index' => 'index,follow',
            'published_time' => '',
            'modified_time' => '',
            'updated_time' => ''
        ];
        break;
}
return $data_seo;
}

function init_cms_pagination($page, $pagination){
    $content = '<ul class="pagination">';
    if ($page > 1) $content .= '<li class="page-item">
                                    <a class="page-link" href="' . getUrlPage($page-1) . '">Prev</a>
                                </li>';
    if ($page > 4) $content .= '<li class="page-item">
                                    <a class="page-link" href="' . getUrlPage(1) . '">1</a>
                                </li>
                                <li class="page-item">
                                    <span class="page-link">...</span>
                                </li>';
    for ($i = $page - 3 ; $i <= $page + 3; $i++) {
        if ($i < 1 || $i > $pagination) continue;
        $active = '';
        if ($i == $page) $active = 'active';
        $content .= '<li class="page-item ' . $active . '">
                        <a class="page-link" href="' . getUrlPage($i) . '">' . $i . '</a>
                    </li>';
    }
    if ($page < $pagination - 3) $content .= '<li class="page-item">
                                                <span class="page-link">...</span>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="' . getUrlPage($pagination) . '">' . $pagination . '</a>
                                            </li>';
    $content .= '<li class="page-item">
                    <a class="page-link" href="' . getUrlPage($page+1) . '">Next</a>
                </li>';
    $content .= '</ul>';
    echo $content;
}

if ( ! function_exists('short_code')) {
    function short_code($content = ''){
        if(Cache::has('short_code-'.md5($content))){
            $short_code = Cache::get('short_code-'.md5($content));
        }else{
            $short_code = ShortCode::where('status', 1)->get();
            Cache::set('short_code-'.md5($content), $short_code, now()->addHours(12));
        }

        foreach($short_code as $s){
            $content = preg_replace("/\[".$s->slug."\]/",$s->content,$content);
        }
        return $content;
    }
}

function convertDateTime($date, $del = false){
    $date = strtotime($date);
    $weekday = date("l");
    $weekday = strtolower($weekday);
    switch($weekday) {
        case 'monday':
            $weekday = 'Thứ hai';
            break;
        case 'tuesday':
            $weekday = 'Thứ ba';
            break;
        case 'wednesday':
            $weekday = 'Thứ tư';
            break;
        case 'thursday':
            $weekday = 'Thứ năm';
            break;
        case 'friday':
            $weekday = 'Thứ sáu';
            break;
        case 'saturday':
            $weekday = 'Thứ bảy';
            break;
        default:
            $weekday = 'Chủ nhật';
            break;
    }
    if(!$del) return 'Ngày '.date('d/m/Y',$date);
    return $weekday.', Ngày '.date('d/m/Y',$date);
}

function getBreadcrumb($breadcrumb){
    $br = "<section class=\"col-12 pl-0 mb-3 font-12 breadcrumb border-bottom pb-1\">
                    <span><a href=\"/\" class=\"text-black6 text-decoration-none\">Trang chủ</a></span>";

    foreach($breadcrumb as $value){
        if ($value['show']) $br .= "<span class=\"text-black3 px-1\">></span>
                <a class=\"text-grey5 text-uppercase\" href=\"{$value['item']}\">{$value['name']}</a>";
    }

    $br .= "</section>";
    return $br;
}

function get_thumbnail($image_url,$width=500,$height=300,$class='img-fluid',$alt='',$layout='responsive', $lazy=true, $resize = true, $path=true){
    if (empty($width)) $width = 500;
    if (empty($height)) $height = 300;
    $source_file = public_path().$image_url;

    $source_file = str_replace('//','/',$source_file);

    $image_name = substr($image_url, 0, strrpos($image_url, '.'));
    $image_name = preg_replace("/\%.{2}/", '-', $image_name);
    $image_ext = substr($image_url, strrpos($image_url, '.'));

    $resize_image_name = $image_name.'-'.$width.'x'.$height.$image_ext;
    $resize_image_file = public_path().'/thumb'.$resize_image_name;
    $resize_image_url = '/thumb'.$resize_image_name;

    if (!empty($resize)) {
        if(file_exists($resize_image_file)){
            $img_src = $resize_image_url;
        }else{
            resize_crop_image($width, $height, $source_file, $resize_image_file);
            if(file_exists($resize_image_file)){
                $img_src = $resize_image_url;
            } else {
                $img_src = $image_url;
            }
        }
    } else {
        $img_src = $image_url;
    }
    $img_src = 'https://' . env('DOMAIN') . $img_src;
    if ($lazy) {
        $lazy = "loading='lazy'";
    } else {
        $lazy = '';
    }
    /*if($path){
        $img_src = env('ASSET_URL_IMAGE','').$img_src;
    }*/
    if (IS_AMP) {
        return "<amp-img class='{$class}' src='{$img_src}' alt='$alt' width='$width' height='$height' layout='{$layout}'></amp-img>";
    } else {
        return "<img $lazy class='{$class}' src='{$img_src}' alt='$alt' width='$width' height='$height' />";
    }
}


function replaceSrcImg($html){
    $dom = new \DOMDocument;
    libxml_use_internal_errors(true);
    $dom->loadHTML('<?xml encoding="utf-8" ?>' .$html);
    $tags = $dom->getElementsByTagName('img');
    foreach ($tags as $tag) {
        $old_src = $tag->getAttribute('src');
        $new_src_url = 'https://forextradingvn.top'.$old_src;
        $tag->setAttribute('src', $new_src_url);
        $tag->setAttribute('data-src', $old_src);
    }
    return $dom->saveHTML();
}
