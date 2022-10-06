<?php
namespace App\Service;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class TelegramBot{
    protected $url = 'https://api.telegram.org/bot';
    private $chatid = [];
    private $mess = '';
    private $document = [];
    private $photo = [];
    private $audio = [];

    private static $instance = null;

    private function __construct()
    {
        $this->url = $this->url.Config::get('app.telegram_token');

    }

    public static function load(){
        if(empty(self::$instance)){
            self::$instance = new self();
        }

        $data_raw = Http::get(self::$instance->url.'/getUpdates')->json();
        if($data_raw['ok'] && !empty($data_raw['result'])){
    
            $arr = json_decode(json_encode($data_raw['result']),true);
            $data = self::getParentStackComplete('chat',$arr);

            return self::$instance->setChatId($data);
            
        }
        return self::$instance;
       
    }

    public function send(){
        $data_return = [];
        if(empty($this->chatid) || empty($this->mess)){
            throw new \Exception("Thieu du lieu!");
        }
        foreach($this->chatid as $chat_id){
            $id = $chat_id['id'];
            $url = $this->url."/sendMessage?chat_id=$id&text=".urlencode($this->mess);
            $data_return[] = Http::get($url)->json();

            if(!empty($this->document)){
                $url = $this->url."/sendDocument?";
                $data_return[] = Http::attach('document', file_get_contents($this->document['path']),$this->document['filename'])->attach('chat_id', $id)->post($url)->json();
            }
            if(!empty($this->photo)){
                $url = $this->url."/sendPhoto?";
                $data_return[] = Http::attach('photo', file_get_contents($this->photo['path']),$this->photo['filename'])->attach('chat_id', $id)->post($url)->json();
            }
            if(!empty($this->audio)){
                $url = $this->url."/sendAudio?";
                $data_return[] = Http::attach('audio', file_get_contents($this->audio['path']),$this->audio['filename'])->attach('chat_id', $id)->post($url)->json();
            }

        }
        $this->mess = '';
        return $data_return;
    }

    public function setMessenges($mess){
        $this->mess = $mess;
        return $this;
    }
    public function setDocument($document, $filename = 'file'){

        $ext = explode(".", $document);
        $ext = end($ext);

        if(parse_url($document, PHP_URL_HOST)){
            $this->document['path'] = $document;
            $this->document['ext'] = $ext;
            $this->document['filename'] = $filename;
        }else{
            $this->document['path'] = public_path($document);
            $this->document['ext'] = $ext;
            $this->document['filename'] = $filename;
        }
        return $this;
    }
    public function setAudio($audio, $filename = 'file'){
        $ext = explode(".", $audio);
        $ext = end($ext);
        if(parse_url($audio, PHP_URL_HOST)){
            $this->audio['path'] = $audio;
            $this->audio['ext'] = $ext;
            $this->audio['filename'] = $filename;
        }else{
            $this->audio['path'] = public_path($audio);
            $this->audio['ext'] = $ext;
            $this->audio['filename'] = $filename;
        }
        return $this;
    }
    public function setPhoto($photo, $filename = 'file'){
        $ext = explode(".", $photo);
        $ext = end($ext);

        if(parse_url($photo, PHP_URL_HOST)){
            $this->photo['path'] = $photo;
            $this->photo['ext'] = $ext;
            $this->photo['filename'] = $filename;
        }else{
            $this->photo['path'] = public_path($photo);
            $this->photo['ext'] = $ext;
            $this->photo['filename'] = $filename;
        }
        
        return $this;
    }

    public function getChatId(){
        return $this->chatid;
    }

    public function setChatId($chat_id){
        if(is_array($chat_id)){
            foreach($chat_id as $k => $item){
                $chat_id[$k]['id'] = (string) $chat_id[$k]['id'];
                $this->chatid[] = $chat_id[$k];
            }

        }else{
            $chat_id['id'] = (string) $chat_id['id'];
            $this->chatid[] = $chat_id;
        }

        return $this;
        
    }

    private static function getParentStackComplete($search, $stack ){

        $stack = json_decode(json_encode($stack),true);

        $result = [];
        foreach( $stack as $key => $item){
            if(isset($item['message'][$search])){
                $result[] = $item['message'][$search];
            }
        }
        $result = array_unique($result, SORT_REGULAR);
        return $result;
    }

}