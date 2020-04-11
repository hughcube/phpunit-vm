<?php
/**
 * Created by IntelliJ IDEA.
 * User: hugh.li
 * Date: 2020/4/11
 * Time: 22:48
 */

namespace HughCube\PHPUnit\VM;

use HughCube\PHPUnit\VM\Constraint\Digit;
use ReflectionClass;
use ReflectionMethod;

trait ExtendTrait
{
    /**
     * 检测是否会抛出指定异常
     *
     * @param string $exceptionClass
     * @param callable $callable
     */
    public static function assertException($exceptionClass, callable $callable)
    {
        $exception = null;

        try {
            $callable();
        } catch (\Throwable $exception) {
        }

        static::assertInstanceOf($exceptionClass, $exception);
    }

    /**
     * 调用类protected方法
     *
     * @param string|object $object 类实例或者类名, 如果是类名就是静态调用
     * @param string $method 方法名
     * @param array $args 参数, 按照顺序给出
     * @return mixed
     * @throws \ReflectionException
     */
    protected static function callProtectMethod($object, $method, array $args = [])
    {
        $class = new ReflectionClass($object);

        /** @var ReflectionMethod $method */
        $method = $class->getMethod($method);
        $method->setAccessible(true);

        return $method->invokeArgs((is_object($object) ? $object : null), $args);
    }

    public static function assertIsDigit($actual, string $message = '')
    {
        static::assertThat(
            $actual,
            new Digit(),
            $message
        );
    }
}
