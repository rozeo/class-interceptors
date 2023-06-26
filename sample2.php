<?php

require_once __DIR__ . '/vendor/autoload.php';


#[Attribute]
class ValidateString implements \Rozeo\ClassInterceptors\InvokableParameterAttribute {
    public function __construct(private readonly int $minLength, private readonly int $maxLength)
    {

    }

    public function invoke($value): void
    {
        if (is_string($value)) {
            $length = mb_strlen($value);
            if ($length < $this->minLength || $length > $this->maxLength) {
                throw new Exception("Invalid length");
            }
        }
    }
}

class Validated {
    public function valid(#[ValidateString(1, 10)] string $value)
    {
        echo "$value is valid!";
    }
}

$interceptor = new \Rozeo\ClassInterceptors\Interceptors\StackedInvokableInterceptor();
$generator = new \Rozeo\ClassInterceptors\ClassInterceptorGenerator($interceptor);

/** @var Validated $v */
$v = $generator->generate(new Validated);

$v->valid("hoge");