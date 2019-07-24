<?php
/**
 * 情景介绍：《大话设计模式》请用面向对象语言实现一个计算器控制台程序，要求输入两个数和运算符号，得到结果，以下是自己在阅读需求后先自行实现的代码
 * 问题分析：错误处理只判断了除数是否为0，对于字符超长，不可计算等都未处理，可以加上try catch
 */
fwrite(STDOUT, "请输入第一个参数：");

$firstParam = trim(fgets(STDIN));

fwrite(STDOUT, "请选择运算符（+、-、*、/、）：");

$operator = trim(fgets(STDIN));

fwrite(STDOUT, "请输入第二个参数：");

$nextParam= trim(fgets(STDIN));

$res = 0;
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

fwrite(STDOUT, "运算结果：$res");
