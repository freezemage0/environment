<?php
/** @author Freezemage <freezemage0@gmail.com> */


namespace Freezemage\Environment;


use PHPUnit\Framework\TestCase;


class EnvironmentTest extends TestCase {
    public function testSet(): void {
        $env = new Environment();
        $env->set('VALUE', 123);
        $this->assertEquals(123, $env->get('VALUE'));
    }

    public function testGetAll(): void {
        $env = Environment::fromFile(__DIR__ . '/preset/test.env');
        $this->assertArrayHasKey('VALUE', $env->getAll());
    }

    public function testHas(): void {
        $env = Environment::fromFile(__DIR__ . '/preset/test.env');
        $this->assertTrue($env->has('VALUE'));
    }

    public function testGet(): void {
        $env = Environment::fromFile(__DIR__ . '/preset/test.env');
        $this->assertEquals(123, $env->get('VALUE'));
    }

    public function testCannotReadFile(): void {
        $this->expectException(MissingFileException::class);
        Environment::fromFile(__DIR__ . '/preset/non-existent-file.env');
    }

    public function testSetDefaultValue(): void {
        $env = new Environment();
        $env->set('EMPTY_VALUE');
        $this->assertEquals(0, $env->get('EMPTY_VALUE'));
    }
}
