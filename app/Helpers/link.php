<?php

use App\Models\Category;
use Illuminate\Support\Str;

function getUrlStory($item, $is_amp = IS_AMP){
    $item = (object) $item;
    $url = 'truyen/'.$item->slug.'-c0';
    $url = url($url);
    if ($is_amp)
        $url .= "/amp";
    return $url;
}

function getUrlChapter($item, $is_amp = IS_AMP){
    $item = (object) $item;
    $url = 'truyen/'.$item->slug.'-c'.$item->id;
    $url = url($url);
    if ($is_amp)
        $url .= "/amp";
    return $url;
}
function getUrlPost($item, $is_amp = false, $exp = false){
    $item = (object) $item;
    $amp = false;
    if (!$is_amp && !$exp){
        $amp = defined('IS_AMP') ? IS_AMP : 0;
    }else if($is_amp){
        $amp = true;
    }else{
        $amp = false;
    }
        
    $slug = '';
    if ($amp)
        $slug = "/amp/";
    $slug .= "/tin-tuc/$item->slug.html";
    return url($slug);
}
function getUrlCate($item, $is_amp = false, $exp = false){
    $slug = '';
    $amp = false;
    $amp = false;
    if (!$is_amp && !$exp){
        $amp = defined('IS_AMP') ? IS_AMP : 0;
    }else if($is_amp){
        $amp = true;
    }else{
        $amp = false;
    }
    if ($amp)
        $slug = "/amp/";
    $slug .= "$item->slug-c$item->id";

    return url($slug);
}
function getUrlTag($item, $is_amp = false, $exp = false){
    $amp = false;
    if (!$is_amp && !$exp){
        $amp = defined('IS_AMP') ? IS_AMP : 0;
    }else if($is_amp){
        $amp = true;
    }else{
        $amp = false;
    }
    $slug = '';
    if ($amp)
        $slug = "/amp/";
    $slug .= "$item->slug-t$item->id";

    return url($slug);
}
function getUrlStaticPage($item, $is_amp = false, $exp = false) {
    $slug = '';
    $amp = false;
    if (!$is_amp && !$exp){
        $amp = defined('IS_AMP') ? IS_AMP : 0;
    }else if($is_amp){
        $amp = true;
    }else{
        $amp = false;
    }
        
    if ($amp)
        $slug = "/amp/";
    $slug .= "$item->slug.html";

    return url($slug);
}

function getUrlLink($slug, $is_amp = ''){
    $url = '';
    if (!$is_amp)
        $is_amp = defined('IS_AMP') ? IS_AMP : 0;
    if ($is_amp)
        $url .= "/amp";
    $check = explode('.',$slug);
    if(count($check) > 1 && end($check) == 'html'){
        $url = url($url.$slug);
    }else{
        $url = url($url.$slug).'/';
    }
    // if (substr($slug, -1) != '/') $slug .= '/';



    return $url;

}
function getUrlPage($page) {
    $parts = parse_url($_SERVER['REQUEST_URI']);
    parse_str($parts['query'], $query);
    $query['page'] = $page;
    return $parts['path'].'?'.http_build_query($query);
}

function getUrlAuthor($item, $is_amp = ''){
    // if (!$is_amp)
    //     $is_amp = defined('IS_AMP') ? IS_AMP : 0;
    // if (empty($item->slug)) return '';
    // $url = '';
    // if ($is_amp)
    //     $url = "/amp/";
    // $slug = $url."author/$item->slug";
    $slug = '/author/'.$item->slug;
    $url = url($slug);

    return $url;
}

function tableOfContent($content) {
    preg_match_all("/<h[23456].*?<\/h[23456]>/",$content,$patt);
    if (empty($patt[0])) return $content;
    $patt2 = $patt[0];
    $index_h2 = 0;
    $index_h3 = 1;
    $danhmuc = "<div class='w-100 border py-2 px-3 mb-3'>
                    <p class='mb-2 d-flex align-items-center summary-title'>
                        <span class=\"square-blue mr-2\"></span>
                        <span class='font-weight-bold font-20 text-blue1 w-100 collapsible'>NỘI DUNG CHÍNH</span>
                    </p>";
    $danhmuc .= "<ul class='list-unstyled mb-2'>";

    foreach ($patt2 as $key=>$item){
        $contentItem = strip_tags($item);
        $slug = toSlug($contentItem,'-');
        if (strpos($item, '</h2>') !== false) {
            $index_h2++;
            $danhmuc .= "<li rel='dofollow' class='mb-1'><a class='text-black1 font-15' href='#$slug' >$index_h2. ".$contentItem."</a></li>";
            $index_h3 = 1;
        } else {
            $danhmuc .= "<li rel='dofollow' class='mb-1 pl-3'><a class='text-black1 font-15' href='#$slug' >$index_h2.$index_h3. ".$contentItem."</a></li>";
            $index_h3++;
        }
        $head = substr($item,0,3);
        $tail = substr($item,3);

        $id = " id='$slug'";
        $content = str_replace($item,$head.$id.$tail,$content);
    }
    $danhmuc .= "</ul></div>";
    $content = "$danhmuc<div class='post-content text-justify'>$content</div>";
    return $content;
}

if (!function_exists('convertDetailTime')) {
    function convertDetailTime($time) {
        $dow = getDay($time, 0);
        $date= date("d/m/Y", strtotime($time));
        $time= date("H:i", strtotime($time));
        return "{$dow}, ngày {$date} - {$time}";
    }
}

function add_amp_to_url($body) {
    return preg_replace_callback('#(<a.*?href=")([^"]*)("[^>]*?>)#i', function($match) {
        $url = $match[2];
        if (strpos($url, '/amp') === false) {
            $url .= '/amp';
        }
        return $match[1] . $url . $match[3];
    }, $body);
}

function getDay($time,$type=0){
    $getday = date('D',strtotime($time));
    $arrayDay = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
    $arrayDayVn = ['Thứ Hai','Thứ Ba','Thứ Tư','Thứ Năm','Thứ Sáu','Thứ Bảy','Chủ Nhật'];
    $arrayDayNumber = ['Thứ 2','Thứ 3','Thứ 4','Thứ 5','Thứ 6','Thứ 7','Chủ nhật'];
    $arrayDayLinkLite = ['thu-2','thu-3','thu-4','thu-5','thu-6','thu-7','chu-nhat'];
    $arrayDayLink = ['t2','t3','t4','t5','t6','t7','cn'];
    if($type == 0){for ($i=0;$i<count($arrayDay);$i++){if($getday == $arrayDay[$i]){return $arrayDayVn[$i];};};};
    if($type == 1){for ($i=0;$i<count($arrayDay);$i++){if($getday == $arrayDay[$i]){return $arrayDayLink[$i];};};};
    if($type == 2){for ($i=0;$i<count($arrayDay);$i++){if($getday == $arrayDay[$i]){return $arrayDayLinkLite[$i];};};};
    if($type == 3){for ($i=0;$i<count($arrayDay);$i++){if($getday == $arrayDay[$i]){return $arrayDayNumber[$i];};};};
    if ($type == 4) {
        $current_type_6 = 'ngày '.date('j',strtotime($time)).' tháng '.date('n',strtotime($time)).' năm '.date('Y',strtotime($time));
        return $current_type_6;
    }
}

function removeIndex($root)
    {
        $i = 'index.php';

        return Str::contains($root, $i) ? str_replace('/'.$i, '', $root) : $root;
    }

