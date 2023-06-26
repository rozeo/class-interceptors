<?php

namespace Rozeo\ClassInterceptors\Interceptors;

use Rozeo\ClassInterceptors\Interceptor;
use Rozeo\ClassInterceptors\InvokableParameterAttribute;

class InvokableParameterAttributeInterceptor implements Interceptor
{

    public function preprocess($class, string $method, array $parameters): void
    {
        $parameterIndex = 0;
        while (true) {
            try {
                $this->preprocessInternal(new \ReflectionClass($class), $method, $parameters, $parameterIndex);
                $parameterIndex++;
            } catch (\OutOfBoundsException) {
                break;
            }
        }
    }

    public function preprocessInternal(\ReflectionClass $class, string $method, array $parameters, int $parameterIndex)
    {
        /** @var InvokableParameterAttribute $attribute */
        foreach ($this->getParameterAttributes($class, $method, $parameterIndex) as $attribute) {
            $attribute->invoke($parameters[$parameterIndex]);
        }
    }

    public function postprocess($class, string $method, array $parameters): void
    {
        // nothing to do
    }

    private function getParameterAttributes(\ReflectionClass $classRef, string $method, int $parameterIndex)
    {
        $parameterRef = $classRef->getMethod($method)?->getParameters()[$parameterIndex]
            ?? throw new \OutOfBoundsException("Out of bound index: $parameterIndex");

        foreach ($parameterRef->getAttributes() as $attribute) {
            if (($attributeInstance = $attribute->newInstance()) instanceof InvokableParameterAttribute) {
                yield $attributeInstance;
            }
        }
    }
}