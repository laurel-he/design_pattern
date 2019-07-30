<?php
/**
 * @author: hexiaojiao@jiapinai.com
 * @todo:
 * time: 2019-07-30 20:07
 */

/**
 * 定义抽象角色类`
 * Interface CollectInter
 */
interface CollectInter
{
    public function collect($price, $num);
    public function input();
}
class Base
{
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

/**
 * 定义具体策略类
 * Class Collect02
 */
class Collect02 extends Base implements CollectInter
{
    public function collect($price, $num, $discount = 1) {
        var_dump('Collect02:', $price * $num * $discount);
        return true;
    }
}

/**
 * Class Discount
 */
class Discount extends Base implements CollectInter
{
    public function collect($price, $num, $discount = 0.8)
    {
        var_dump('Discount:', $price * $num * $discount);
        return true;
    }
}

/**
 * Class Reduce
 */
class Reduce extends Base implements  CollectInter
{
    public function collect($price, $num, $total = 100, $reduce = 0)
    {
        if ($price * $total >= $total) {
            var_dump('Reduce:', ($price * $total) - $reduce);
        } else {
            var_dump('Reduce:', $price * $total);
        }
        return true;
    }
}
/**
 * 环境角色类
 * Class Main
 */
class Main
{
    private $_strategy;
    private $_isChange;
    public function __construct(CollectInter $collectInter)
    {
        $this->_strategy = $collectInter;
    }
    public function change(CollectInter $collectInter)
    {
        $this->_strategy = $collectInter;
        $this->_isChange = true;
    }
    public function beginCollect()
    {
        if ($this->_isChange) {
            echo "改变收银方式：";
            $this->_strategy->input();
        } else {
            $this->_strategy->input();
        }
    }
}
$strategy = new Main(new Discount());
$strategy->beginCollect();
$strategy->change(new Collect02());
$strategy->beginCollect();


