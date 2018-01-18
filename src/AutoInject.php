<?php
namespace hxv\AutoInject;

use ReflectionClass;
use ReflectionMethod;
use ReflectionParameter;

class AutoInject {
    public function create(string $class) {
        if (!class_exists($class))
            throw new Exception("Class {$class} doesn't exist");

        if(null !== $constructor = (new ReflectionClass($class))->getConstructor())
            $arguments = $this->arguments($constructor);

        return new $class(...$arguments ?? []);
    }

    protected function arguments(ReflectionMethod $method) : array {
        return array_map([$this, 'argument'], $method->getParameters());
    }

    protected function argument(ReflectionParameter $parameter) {
        if ($parameter->isVariadic())
            throw new Exception("Parameter \${$parameter->getName()} is variadic and can't be resolved");

        if ($parameter->getClass())
            return $this->create($parameter->getType());

        if ($parameter->isDefaultValueAvailable())
            return $parameter->getDefaultValue();

        throw new Exception("Parameter \${$parameter->getName()} can't be automatically resolved");
    }
}
