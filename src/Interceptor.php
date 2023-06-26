<?php

namespace Rozeo\ClassInterceptors;

interface Interceptor
{
    public function preprocess($class, string $method, array $parameters): void;

    public function postprocess($class, string $method, array $parameters): void;
}