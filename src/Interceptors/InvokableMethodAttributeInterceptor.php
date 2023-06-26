<?php

namespace Rozeo\ClassInterceptors\Interceptors;

use Rozeo\ClassInterceptors\Interceptor;
use Rozeo\ClassInterceptors\InvokableMethodAttribute;

class InvokableMethodAttributeInterceptor implements Interceptor
{
    /**
     * @throws \ReflectionException
     */
    public function preprocess($class, string $method, array $parameters): void
    {
        /** @var InvokableMethodAttribute $attribute */
        foreach ($this->getMethodAttributes(new \ReflectionClass($class), $method) as $attribute) {
            $attribute->invoke($parameters);
        }
    }

    public function postprocess($class, string $method, array $parameters): void
    {
        // nothing to do
    }

    /**
     * @param \ReflectionClass $class
     * @param string $method
     * @return \Generator
     * @throws \ReflectionException
     */
    private function getMethodAttributes(\ReflectionClass $classRef, string $method): \Generator
    {
        foreach ($classRef->getMethod($method)?->getAttributes() as $attribute) {
            if (($attributeInstance = $attribute->newInstance()) instanceof InvokableMethodAttribute) {
                yield $attributeInstance;
            }
        }
    }
}