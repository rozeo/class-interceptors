<?php

namespace Rozeo\ClassInterceptors;

use Attribute;

#[Attribute]
interface InvokableMethodAttribute
{
    public function invoke(array $values): void;
}