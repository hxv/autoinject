<?php

class ClassWithDependency {
    /** @var string */
    protected $default;

    public function __construct(Dependency $dependency, string $default = 'default_value') {
        $this->default = $default;
    }

    public function default() : string {
        return $this->default;
    }
}
