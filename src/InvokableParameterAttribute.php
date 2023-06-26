<?php

namespace Rozeo\ClassInterceptors;

use Attribute;

#[Attribute]
interface InvokableParameterAttribute
{
    public function invoke($value): void;
}