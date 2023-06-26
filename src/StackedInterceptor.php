<?php

namespace Rozeo\ClassInterceptors;

class StackedInterceptor implements Interceptor
{
    /**
     * @param Interceptor[] $interceptors
     */
    public function __construct(private readonly array $interceptors)
    {
    }

    public function preprocess($class, string $method, array $parameters): void
    {
        foreach ($this->interceptors as $interceptor) {
            $interceptor->preprocess($class, $method, $parameters);
        }
    }

    public function postprocess($class, string $method, array $parameters): void
    {
        foreach ($this->interceptors as $interceptor) {
            $interceptor->postprocess($class, $method, $parameters);
        }
    }
}