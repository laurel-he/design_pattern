<?php
/**
 * @author: hexiaojiao@jiapinai.com
 * @todo:
 * time: 2019-07-24 18:06
 */

namespace calculate;


use mysql_xdevapi\Exception;

class Calculate03
{
    public $firstParam;
    public $nextParam;
    protected function calculate()
    {
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

        switch ($operator) {
            case '+' :
                $obj = new CalculateAdd();
                break;
            case '-' :
                $obj = new CalculateReduce();
                break;
            case '*' :
                $obj = new CalculateRide();
                break;
            case '/':
                $obj = new CalculateExcept();
        }

        fwrite(STDOUT, "请输入第二个参数：");

        $nextParam= trim(fgets(STDIN));

        $obj->firstParam = $firstParam;
        $obj->nextParam = $nextParam;

        $res = $obj->calculate();

        fwrite(STDOUT, "运算结果：$res");
    }
}
$object = new CalculateView();
$object->viewSet();
class CalculateAdd extends Calculate03
{
    public function calculate()
    {
        return $this->firstParam + $this->nextParam;
    }
}
class CalculateReduce extends Calculate03
{
    public function calculate()
    {
        return $this->firstParam - $this->nextParam;
    }
}
class CalculateRide extends Calculate03
{
    public function calculate()
    {
        return $this->firstParam * $this->nextParam;
    }
}
class CalculateExcept extends Calculate03
{
    public function calculate()
    {
        if ($this->nextParam == 0) {
            throw new Exception('被除数不能为0!');
        } else {
            return $this->firstParam + $this->nextParam;
        }
    }
}
