return new class($interceptor, $parentClass) extends [classname] {
    function __construct(private $interceptor, private $parentClass) {
    }

    private function __call_method__(string $method, ...$variables) {
        $this->interceptor->preprocess($this->parentClass, $method, $variables);
        $this->parentClass->$method(...$variables);
        $this->interceptor->postprocess($this->parentClass, $method, $variables);
    }

    [methods]
};