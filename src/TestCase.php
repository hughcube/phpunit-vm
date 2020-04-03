<?php
/**
 * Created by IntelliJ IDEA.
 * User: hugh.li
 * Date: 2019-07-27
 * Time: 15:42
 */

namespace HughCube\PHPUnit\VM;

/**
 * Class TestCase
 * @package HughCube\PHPUnit\VM
 */
class TestCase extends \PHPUnit\Framework\TestCase
{
    use AssertExceptionTrait;
    use CallProtectMethodTrait;
}
