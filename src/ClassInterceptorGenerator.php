<?php

namespace Rozeo\ClassInterceptors;

class ClassInterceptorGenerator
{
    private string $baseTemplate;

    public function __construct(private readonly Interceptor $interceptor)
    {
        $this->baseTemplate = file_get_contents(__DIR__ . '/../class_templates/class.tpl');
    }

    public function generate(mixed $targetClass): mixed
    {
        $reflection = new \ReflectionClass($targetClass);
        $template = $this->baseTemplate;

        $template = preg_replace('/\[classname\]/', $reflection->getName(), $template);

        $methods = array_map(
            function (\ReflectionMethod $method) {
                if (!$method->isPublic()) {
                    return "";
                }

                $parameters = implode(', ',
                    array_map(function (\ReflectionParameter $parameter) {
                        return "$" . $parameter->getName();
                    },
                        $method->getParameters())
                );


                return "public function {$method->getName()}({$parameters}) {\n" .
                    "\$this->__call_method__(\"{$method->getName()}\", {$parameters});\n" .
                    "}\n";

            },
            $reflection->getMethods(),
        );

        $template = preg_replace('/\[methods\]/', implode("\n", $methods), $template);

        return $this->generateEval($template, $targetClass);
    }

    private function generateEval(string $template, $targetClass)
    {
        $interceptor = $this->interceptor;
        $parentClass = $targetClass;
        return eval($template);
    }
}