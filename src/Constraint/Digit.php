<?php
/**
 * Created by IntelliJ IDEA.
 * User: hugh.li
 * Date: 2020/4/11
 * Time: 22:54
 */

namespace HughCube\PHPUnit\VM\Constraint;

use PHPUnit\Framework\Constraint\Constraint;

class Digit extends Constraint
{
    /**
     * Returns a string representation of the constraint.
     */
    public function toString(): string
    {
        return \sprintf(
            'is of type "%s"',
            'digit'
        );
    }

    /**
     * Evaluates the constraint for parameter $other. Returns true if the
     * constraint is met, false otherwise.
     *
     * @param mixed $other value or object to evaluate
     */
    protected function matches($other): bool
    {
        return is_numeric($other)
            && ctype_digit(strval($other))
            && false === strpos(strval($other), '.');
    }
}
