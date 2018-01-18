<?php
namespace hxv\AutoInject;

include_once(__DIR__ . '/classes/ClassWithoutConstructor.php');
include_once(__DIR__ . '/classes/Dependency.php');
include_once(__DIR__ . '/classes/ClassWithDependency.php');
include_once(__DIR__ . '/classes/ClassWithUnresolvableDependency.php');
include_once(__DIR__ . '/classes/ClassWithVariadicDependency.php');

use PHPUnit\Framework\TestCase;
use ClassWithoutConstructor;
use ClassWithDependency;
use ClassWithUnresolvableDependency;
use ClassWithVariadicDependency;

class InjectorTest extends TestCase {
    protected function subject() : AutoInject {
        return new AutoInject();
    }

    /**
     * @expectedException \hxv\AutoInject\Exception
     * @expectedExceptionMessage Class UnknownClass doesn't exist
     */
    public function test_throws_exception_for_unknown_class() {
        $this->subject()->create('UnknownClass');
    }

    public function test_creates_class_without_constructor() {
        $this->assertInstanceOf(ClassWithoutConstructor::class, $this->subject()->create(ClassWithoutConstructor::class));
    }

    public function test_creates_class_with_constuctor_filling_dependency() {
        $this->assertInstanceOf(ClassWithDependency::class, $this->subject()->create(ClassWithDependency::class));
    }

    /**
     * @expectedException \hxv\AutoInject\Exception
     * @expectedExceptionMessage Parameter $arg can't be automatically resolved
     */
    public function test_throws_exception_for_unresolvable_argument() {
        $this->subject()->create(ClassWithUnresolvableDependency::class);
    }

    /**
     * @expectedException \hxv\AutoInject\Exception
     * @expectedExceptionMessage Parameter $dependency is variadic and can't be resolved
     */
    public function test_throws_exception_for_variadic_argument() {
        $this->subject()->create(ClassWithVariadicDependency::class);
    }
}
