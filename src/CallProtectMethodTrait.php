<?php
/**
 * Created by IntelliJ IDEA.
 * User: hugh.li
 * Date: 2020/4/2
 * Time: 11:23
 */

namespace HughCube\PHPUnit\VM;

use ReflectionClass;
use ReflectionMethod;

trait CallProtectMethodTrait
{
    /**
     * 调用类protected方法
     *
     * @param string|object $object 类实例或者类名, 如果是类名就是静态调用
     * @param string $method 方法名
     * @param array $args 参数, 按照顺序给出
     * @return mixed
     * @throws \ReflectionException
     */
    protected function callProtectMethod($object, $method, array $args = [])
    {
        $class = new ReflectionClass($object);

        /** @var ReflectionMethod $method */
        $method = $class->getMethod($method);
        $method->setAccessible(true);

        return $method->invokeArgs((is_object($object) ? $object : null), $args);
    }
}
