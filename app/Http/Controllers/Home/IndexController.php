<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Model\Board;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    //
    public function index(Board $boardModel){
        $boardModel->calc([
            [1,4,5,0,0,7,0,0,0],
            [0,0,0,2,0,0,0,0,4],
            [0,0,0,8,3,0,1,0,5],
            [0,0,0,0,0,0,0,2,7],
            [0,0,2,4,0,5,8,0,0],
            [8,1,0,0,0,0,0,0,0],
            [6,0,7,0,2,9,0,0,0],
            [4,0,0,0,0,8,0,0,0],
            [0,0,0,7,0,0,2,9,3]
        ]);

        return response()->json($boardModel->arr);
    }

    public function index2(Board $boardModel)
    {
        $boardModel->loopArr();
        foreach($boardModel->array as $key=>$val){
            foreach ($val as $k=>$v){
                $boardModel->arr[$key][$k]=$v['value'];
            }
        }
        return response()->json($boardModel->arr);
    }
}
