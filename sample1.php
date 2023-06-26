<?php

use Rozeo\ClassInterceptor\ClassInterceptorGenerator;
use Rozeo\ClassInterceptor\Interceptor;

require_once __DIR__ . '/vendor/autoload.php';

class TestClass {
    public function call($val, $hoge) {
        echo "call $val, $hoge\n";
    }
}

class SampleInterceptor implements Interceptor {
    public function preprocess($class, string $method, array $parameters): void {
        echo "previous\n";
    }

    public function postprocess($class, string $method, array $parameters): void {
        echo "postprocess\n";
    }
};

$generator = new ClassInterceptorGenerator(new SampleInterceptor());

/** @var TestClass $overrideClass */
$overrideClass = $generator->generate(new TestClass());

$overrideClass->call("hogehoge", "fuga");

