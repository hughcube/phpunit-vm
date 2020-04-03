<?php
/**
 * Created by IntelliJ IDEA.
 * User: hugh.li
 * Date: 2020/4/2
 * Time: 11:25
 */

namespace HughCube\PHPUnit\VM;

trait AssertExceptionTrait
{
    /**
     * 检测是否会抛出指定异常
     *
     * @param string $exceptionClass
     * @param callable $callable
     */
    protected function assertException($exceptionClass, callable $callable)
    {
        $exception = null;

        try {
            $callable();
        } catch (\Throwable $exception) {
        }

        $this->assertInstanceOf($exceptionClass, $exception);
    }
}
