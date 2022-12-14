<?php

namespace App\Service;
use Illuminate\Support\Facades\DB;

class InterLink{
  public $data_inter = [];
  public $content = '';
  private static $_instance = null;
  private $data_inter_link = [];
  private $setting_link = null;
  private $khoang_cach = null;


  public function __construct($count, $khoang_cach){
    $this->setting_link = $count;
    $this->khoang_cach = $khoang_cach;
  }

  public function setcontent($content){
    $this->content = $content;
    return $this;
  }

  public static function init($count=10, $khoang_cach=200){
    if(empty(self::$_instance)){
      self::$_instance = new self($count, $khoang_cach);
    }
    return self::$_instance;
  }

  public function setDataInterLink($arr = []){
    if(!empty($arr)){
      $this->data_inter_link = $arr;
      return $this;
    }
    throw new \Exception('empty data Internal link');
  }

  public function get(){
    if(empty($this->data_inter_link)){
        $data = DB::table('internal_link')->join('internal_link_id', function($q){
            $q->on('internal_link.id', '=', 'internal_link_id.id_internal_link');
        })->whereNotIn('internal_link.id', [1,2])->get()->toArray();
        $data = array_map(function($item){
            return [
                'id' => $item->id,
                'title' => $item->title,
                'keyword' => $item->keyword,
                'href' => $item->href,
                'is_tab' => $item->is_tab,
                'is_tag' => $item->is_tag,
                'id_internal_link' => $item->id_internal_link,
            ];
        },$data);
        $this->data_inter_link = $data;
    }
    return $this->handleInternalLink();
  }

  private function handleInternalLink()
    {
      
        $content = $this->content;
        $data_internal_link = $this->data_inter_link;
        if(empty($data_internal_link)){
            $obj = new \stdClass;
            $obj->content = $content;
            $obj->statictis = '';
            return $obj;
        }
        if(empty($content)) throw new \Exception('empty data content');
        //sort ????? ??u ti??n link c?? ????? d??i l??n ch??n tr?????c
        usort($data_internal_link, function ($a, $b) {
            return strlen($a['keyword']) < strlen($b['keyword']);
        });
        // d??ng n??y remove c??c interlink c?? ????? ch??n c??i m???i
        $content      = preg_replace('/<a class=["|\']interlink["|\'].*?>(.*?)<\/a>/m', '$1', $content);
      
        $array_name   = [];
        $arr_inter  = [];
        $arr_inter_main  = [];
        // x??? l?? c??c ??o???n heading, a, b, strong, td
        $content      = preg_replace('/(<(?P<tag_name>(h[1-6]|a|b|strong|td))( [^>]*)?>[\s\S]*?<\/(?P=tag_name)>)/m', '<[.,:$1:,.]>', $content);
        // ch??n t???t c??? internal link th???a m??n kh??ng tr??ng l???p, tuy nhi??n ch??a check s??? l?????ng v?? m???t ?????
        if (!empty($data_internal_link)) foreach ($data_internal_link as $value) {
            $keyword    = strlen($value['keyword']) > 3 ? $value['keyword'] : $value['keyword'] . ' ';
            preg_match('/<a([\s\S]*?)>[\s\S]*?' . $keyword . '[\s\S]*?<\/a>/', $content, $matches);
            if (!in_array($value['id_internal_link'], $arr_inter_main) && empty($matches)) {
                if (preg_match('/' . $keyword . '/iu', $content)) {
                    $is_tab  = $value['is_tab'] == 1 ? "target='_blank'" : '';
                    $is_tag  = $value['is_tag'] != 1 ? "rel='nofollow'" : '';

                    $name    = preg_quote($keyword, '/');
                    $url     = $value['href'];
                    $replace = "<a class=\"interlink\" $is_tag title=\"$1\" href=\"$url\" $is_tab>$1</a>";
                    // kh??ng ch??n v??o gi???a 2 k?? t??? <> v?? []
                    $reg     = '/(?!(?:[^\[]+[\]]|[^<]+[>]))\b($name)\b/ui';
                    $regexp  = str_replace('$name', $name, $reg);
                    $newtext = preg_replace($regexp, $replace, $content, 1);

                    if ($newtext != $content) {
                        array_push($array_name, $name);
                        $content = $newtext;
                        $arr_inter[$value['id']. ''] = $name;
                        array_push($arr_inter_main, $value['id_internal_link']);
                    }
                }
            }
        }

        $content      = str_replace('<[.,:', '', $content);
        $content      = str_replace(':,.]>', '', $content);


        $khoang_cach = $this->khoang_cach;
        $setting_link = $this->setting_link;
        $text_priority = "_17_";
        $content_strip_tag = preg_replace('/<a class=["|\']interlink["|\'].*?>(.*?)<\/a>/m', '_$1_', $content);
      
        // c??c link do BTV ch??n tay ???????c ????nh d???u l?? ??u ti??n
        $content_strip_tag = preg_replace('/<a.*?>(.*?)<\/a>/m', $text_priority, $content_strip_tag);
        $content_strip_tag = strip_tags($content_strip_tag);

        //b??? h???t ?????u c???a c??c t??? ????? t??nh kho???ng c??ch cho chu???n
        $content_strip_tag = $this->toNormal($content_strip_tag);
        for ($i = 0; $i < count($array_name); $i++) {
            $array_name[$i] = "_" . $array_name[$i] . "_";
        }
        $imp = implode('|', $array_name);
        $imp .= '|' . $text_priority;
        $imp = $this->toNormal($imp);
        preg_match_all("#$imp#i", $content_strip_tag, $new_matches, PREG_OFFSET_CAPTURE);
        $arr_interlink = $new_matches[0];

        
        
        //??o???n n??y ????? l???y text nguy??n b???n c???a keyword
        for($i = 0; $i < count($arr_interlink); $i++) {
            //2 dong nay de dam bao luon co index 3
            $arr_interlink[$i][3] = $arr_interlink[$i][0];
            foreach($array_name as $item) {
                if (strtolower($arr_interlink[$i][0]) == strtolower($this->toNormal($item))) {
                    $arr_interlink[$i][3] = $item;
                }
            }
        }
        $num_link = count($arr_interlink);
        $index = 1;

        //doan nay xu ly khoang cach
        while($index < $num_link){
            // kho???ng c??ch keyword hi???n t???i ?????n keyword tr?????c ????
            $check_kc = $arr_interlink[$index][1] - $arr_interlink[$index-1][1] - strlen($arr_interlink[$index-1][0]);
            $is_remove = $check_kc < $khoang_cach ? true : false;
            // check n???u c??? 2 keyword ?????u l?? c???a BTV ch??n th?? kh??ng remove
            $is_remove =  $arr_interlink[$index][0] == $text_priority && $arr_interlink[$index-1][0] == $text_priority ? false : $is_remove;
            if ($is_remove) {
                $index_remove = $arr_interlink[$index][0] != $text_priority ? $index : $index - 1;
                $name_replace = trim($arr_interlink[$index_remove][3], "_");
                $content = preg_replace_callback("/<a class=[\"|\']interlink[\"|\'] [^>]*?>($name_replace)<\/a>/ui", function ($matches) use ($name_replace) {
                    return empty($matches[1]) ? $name_replace : $matches[1];
                }, $content);
                array_splice($arr_interlink, $index_remove, 1);
                $num_link--;
            } else {
                $index++;
            }
        }
      
        $count_link = 0;
        // dd($content);
      
        //doan nay xu ly so luong internal link v?? th???ng k??
        $internal_link_added = [];
        foreach($arr_interlink as $item) {
            if($item[0] != $text_priority) {
                $count_link++;
                $name_replace = trim($item[3], "_");
                if ($count_link > $setting_link) {
                    $content = preg_replace_callback("/<a class=[\"|\']interlink[\"|\'] [^>]*?>($name_replace)<\/a>/ui", function ($matches) use ($name_replace) {
                        return empty($matches[1]) ? $name_replace : $matches[1];
                    }, $content);
                } else {
                    $id_keyword = array_search($name_replace, $arr_inter);
                    if(!empty($id_keyword)) {
                        array_push($internal_link_added, $id_keyword);
                    }
                }
            }
        }   

 
      $obj = new \stdClass;
      $obj->content = $content;
      $obj->statictis = !empty($internal_link_added) ? json_encode($internal_link_added) : '';
      return $obj;
    }

  public function toNormal($str) {
    $str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)/", 'a', $str);
    $str = preg_replace("/(??|??|???|???|???|??|???|???|???|???|???)/", 'e', $str);
    $str = preg_replace("/(??|??|???|???|??)/", 'i', $str);
    $str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)/", 'o', $str);
    $str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???)/", 'u', $str);
    $str = preg_replace("/(???|??|???|???|???)/", 'y', $str);
    $str = preg_replace("/(??)/", 'd', $str);
    $str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)/", 'A', $str);
    $str = preg_replace("/(??|??|???|???|???|??|???|???|???|???|???)/", 'E', $str);
    $str = preg_replace("/(??|??|???|???|??)/", 'I', $str);
    $str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???|??|???|???|???|???|???)/", 'O', $str);
    $str = preg_replace("/(??|??|???|???|??|??|???|???|???|???|???)/", 'U', $str);
    $str = preg_replace("/(???|??|???|???|???)/", 'Y', $str);
    $str = preg_replace("/(??)/", 'D', $str);
    return $str;
}
  
}