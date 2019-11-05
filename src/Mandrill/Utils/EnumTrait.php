<?php

namespace Addgod\MandrillTemplate\Mandrill\Utils;

use ReflectionClass;

/**
 * Trait for simple enums.
 */
trait EnumTrait
{
    /**
     * Get a list of possible values.
     *
     * @return array
     * @throws \ReflectionException
     */
    public static function getValues(): array
    {
        $class = new ReflectionClass(__CLASS__);

        return $class->getConstants();
    }
}
