<?php

class ClassWithVariadicDependency {
    public function __construct(Dependency ...$dependency) {
        //
    }
}
