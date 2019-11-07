<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BoardOwn extends Model
{
    public $loop=0;
    public $loopNum=0;

    public function loopArr(){
        ++$this->loopNum;
        $this->loop=0;
        foreach ($this->arr as $key => $val) {
            foreach ($val as $k => $v) {
                if ($v == 0) {
                    $currentArr = $this->current($key, $k);
                    if (count($currentArr) == 1) {
                        $this->array[$key][$k] = [
                            'value' => current($currentArr),
                        ];
                    } else {
                        $this->array[$key][$k] = [
                            'value' => '',
                            'maybe' => $currentArr
                        ];
                        ++$this->loop;
                    }
                } else {
                    $this->array[$key][$k] = [
                        'value' => $this->arr[$key][$k],
                    ];
                }
            }
        }
        var_dump($this->loop);
        if($this->loopNum>81){
            return $this->array;
        }
        if($this->loop>0){
            $this->loopArr();
        }
        return $this->array;
    }

    public function current($line,$row){
        $lineArr=$this->line($line);
        $rowArr=$this->row($row);
        $blockArr=$this->block($line,$row);
        $existence=array_unique(array_merge($lineArr,$rowArr,$blockArr));
        return array_diff($this->numberArr,$existence);
    }

    public function line($line){
        return array_intersect($this->arr[$line],$this->numberArr);
    }
    public function row($row){
        for($i=0;$i<9;$i++){
            $rowArr[]=$this->arr[$i][$row];
        }
        return array_intersect($rowArr,$this->numberArr);
    }
    public function block($line,$row){
        $lineRange=$this->blockRange[floor($line/3)];
        $rowRange=$this->blockRange[floor($row/3)];
        foreach ($lineRange as $key=>$val){
            foreach ($rowRange as $k=>$v){
                $block[]=$this->arr[$val][$v];
            }
        }
        return array_intersect($block,$this->numberArr);
    }





























    public $numberArr=[1,2,3,4,5,6,7,8,9];
    public $blockRange=[
        [0,1,2],
        [3,4,5],
        [6,7,8]
    ];
    public $arr=[
        [1,4,5,0,0,7,0,0,0],
        [0,0,0,2,0,0,0,0,4],
        [0,0,0,8,3,0,1,0,5],
        [0,0,0,0,0,0,0,2,7],
        [0,0,2,4,0,5,8,0,0],
        [8,1,0,0,0,0,0,0,0],
        [6,0,7,0,2,9,0,0,0],
        [4,0,0,0,0,8,0,0,0],
        [0,0,0,7,0,0,2,9,3]
    ];
    public $array=[];
}
