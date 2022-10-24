<?php

namespace App\BuilderModel;

use Illuminate\Support\Collection;

class ChapterSort extends \Illuminate\Database\Eloquent\Builder{
    public function chapter_sort(){
       
        $data = $this->model->chapter->mapWithKeys(function($item){
            return [$this->getNumberFromString($item->title) => $item];
        });
        $data = $data->sortKeysUsing(function($a,$b){
            if ($a==$b) return 0;
            return ($a<$b)?1:-1;
        });
        $this->model->chapter = $data;
        return $this->model;
    }

    private function getNumberFromString($string){
        $int = (int) filter_var($string, FILTER_SANITIZE_NUMBER_INT);
        if($int < 0){
            return $int*-1;
        }
        return $int;
    }
}