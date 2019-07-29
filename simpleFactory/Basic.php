<?php
/**
 * @author: hexiaojiao@jiapinai.com
 * @todo:
 * time: 2019-07-29 17:29
 */

namespace calculate;

interface BasicIn
{
    function getName();
}
/**
 * 实现一个基础的工厂模式
 * Class Basic
 * @package calculate
 */
class Basic implements BasicIn
{
    public function __construct()
    {
    }

    public function getName()
    {
        return "Laurel-------";
        // TODO: Implement getName() method.
    }
}
class BasicFactory
{
    public static function create()
    {
        return new Basic();
    }
}
$obj = BasicFactory::create();
echo $obj->getName();
