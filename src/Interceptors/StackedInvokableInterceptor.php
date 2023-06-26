<?php

namespace Rozeo\ClassInterceptors\Interceptors;

use Rozeo\ClassInterceptors\Interceptors\InvokableParameterAttributeInterceptor;
use Rozeo\ClassInterceptors\StackedInterceptor;

class StackedInvokableInterceptor extends StackedInterceptor
{
    public function __construct()
    {
        parent::__construct([
            new InvokableMethodAttributeInterceptor(),
            new InvokableParameterAttributeInterceptor(),
        ]);
    }
}