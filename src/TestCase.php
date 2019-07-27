<?php
/**
 * Created by IntelliJ IDEA.
 * User: hugh.li
 * Date: 2019-07-27
 * Time: 15:42
 */

namespace HughCube\PHPUnit\VM;

use ReflectionClass;
use ReflectionMethod;

class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * 调用类protected方法
     *
     * @param object|string $class 类实例或者类名, 如果是类名就是静态调用
     * @param string $method 方法名
     * @param array $args 参数, 按照顺序给出
     * @return mixed
     * @throws \ReflectionException
     */
    protected function callMethod($class, $method, array $args = [])
    {
        $class = new ReflectionClass($class);

        /** @var ReflectionMethod $method */
        $method = $class->getMethod($method);
        $method->setAccessible(true);

        return $method->invokeArgs((is_object($class) ? $class : null), $args);
    }

    /**
     * 检测是否会抛出指定异常
     *
     * @param $exceptionClass
     * @param callable $callable
     */
    protected function assertException($exceptionClass, callable $callable)
    {
        $exception = null;

        try{
            $callable();
        }catch(\Throwable $exception){
        }

        $this->assertInstanceOf($exceptionClass, $exception);
    }
}
