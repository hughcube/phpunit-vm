<?php
/**
 * Created by IntelliJ IDEA.
 * User: hugh.li
 * Date: 2020/4/2
 * Time: 11:37
 */

namespace HughCube\PHPUnit\VM\Laravel;

use HughCube\PHPUnit\VM\ExtendTrait;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

/**
 * Class LumenTestCase
 * @package HughCube\PHPUnitVM\Laravel
 * @property \Illuminate\Testing\TestResponse|\Illuminate\Http\Response $response
 */
abstract class LumenTestCase extends BaseTestCase
{
    use ExtendTrait;
}
