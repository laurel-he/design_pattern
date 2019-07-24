<?php

namespace calculate;

/**
 * 情景介绍：为了提高代码的可复用性，可维护性，可扩展性，使用面向对象实现计算器
 * Class Calculate2
 * @package calculate
 */
class Calculate2
{
    public function calculate($firstParam, $operator, $nextParam)
    {
        switch ($operator) {
            case "+":
                $res = $firstParam + $nextParam;
                break;
            case "-":
                $res = $firstParam - $nextParam;
                break;
            case "*":
                $res = $firstParam * $nextParam;
                break;
            case "/":
                if ($nextParam == 0) {
                    $res = 0;
                } else {
                    $res = $firstParam * $nextParam;
                }
                break;
            default:
                $res = "错误！";
                break;
        }
        return $res;
    }
}
class CalculateView
{
    public function viewSet()
    {
        fwrite(STDOUT, "请输入第一个参数：");

        $firstParam = trim(fgets(STDIN));

        fwrite(STDOUT, "请选择运算符（+、-、*、/、）：");

        $operator = trim(fgets(STDIN));

        fwrite(STDOUT, "请输入第二个参数：");

        $nextParam= trim(fgets(STDIN));

        $obj = new Calculate2();

        $res = $obj->calculate($firstParam, $operator, $nextParam);

        fwrite(STDOUT, "运算结果：$res");
    }
}
$object = new CalculateView();
$object->viewSet();
