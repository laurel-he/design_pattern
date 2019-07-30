<?php

/**
 * 在不使用设计模式的情况下，实现一个根据单价和数量计算金额的算法
 * Class Collect01
 */
class Collect01
{
    private function collect($price, $num, $discount = 1) {
        return $price * $num * $discount;
    }
    public function input($discount = 1)
    {
        fwrite(STDOUT, '请输入单价');
        $price = trim(fgets(STDIN));
        fwrite(STDOUT, '请输入数量');
        $num = trim(fgets(STDIN));
        $res = $this->collect($price, $num, $discount);
        return $res;
    }
}
$collect = new Collect01();
$res = $collect->input();
var_dump($res);
