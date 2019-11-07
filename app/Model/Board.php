<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    public $arr = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if ($attributes == null) {
            $this->clear();
        } else {
            $this->arr = $attributes;
        }
    }

    public function clear()
    {
        for ($i = 0; $i < 9; $i++) {
            for ($j = 0; $j < 9; $j++) {
                $this->arr[$i][$j] = [];
                for ($k = 1; $k <= 9; $k++) {
                    $this->arr[$i][$j][$k] = $k;
                }
            }
        }
    }

    public function calc($arr)
    {
        $this->clear();
        $this->set($arr);
        $this->_calc();
        $this->dump();
    }

    public function set($data)
    {
        for ($i = 0; $i < 9; $i++) {
            for ($j = 0; $j < 9; $j++) {
                if ($data[$i][$j] > 0) {
                    $this->setCell($i, $j, $data[$i][$j]);
                }
            }
        }
    }

    public function setCell($row, $col, $value)
    {
        $this->arr[$row][$col] = [$value => $value];
        //row
        for ($i = 0; $i < 9; $i++) {
            if ($i != $col) {
                if (!$this->removeValue($row, $i, $value)) {
                    return false;
                }
            }
        }
        //col
        for ($i = 0; $i < 9; $i++) {
            if ($i != $row) {
                if (!$this->removeValue($i, $col, $value)) {
                    return false;
                }
            }
        }
        //square
        $rs = floor($row / 3) * 3;
        $cs = floor($col / 3) * 3;
        for ($i = $rs; $i < $rs + 3; $i++) {
            for ($j = $cs; $j < $cs + 3; $j++) {
                if ($i != $row && $j != $col) {
                    if (!$this->removeValue($i, $j, $value)) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    public function removeValue($row, $col, $value)
    {
        $count = count($this->arr[$row][$col]);
        if ($count == 1) {
            $ret = !isset($this->arr[$row][$col][$value]);
            return $ret;
        }
        if (isset($this->arr[$row][$col][$value])) {
            unset($this->arr[$row][$col][$value]);
            if ($count - 1 == 1) {
                return $this->setCell($row, $col, current($this->arr[$row][$col]));
            }
        }
        return true;
    }

    public function _calc()
    {
        for ($i = 0; $i < 9; $i++) {
            for ($j = 0; $j < 9; $j++) {
                if (count($this->arr[$i][$j]) == 1) {
                    continue;
                }
                foreach ($this->arr[$i][$j] as $v) {
                    $flag = false;
                    $t = new Board($this->arr);
                    if (!$t->setCell($i, $j, $v)) {
                        continue;
                    }
                    if (!$t->_calc()) {
                        continue;
                    }
                    $this->arr = $t->arr;
                    return true;
                }
                return false;
            }
        }
        return true;
    }

    public function dump()
    {
        for ($i = 0; $i < 9; $i++) {
            for ($j = 0; $j < 9; $j++) {
                $c = count($this->arr[$i][$j]);
                if ($c == 1) {
                    echo " " . current($this->arr[$i][$j]) . " ";
                } else {
                    echo "(" . $c . ")";
                }
            }
            echo "\n";
        }
        echo "\n";
    }
}
