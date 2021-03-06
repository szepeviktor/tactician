<?php
declare(strict_types=1);

namespace League\Tactician\Tests\Handler\Mapping;

use League\Tactician\Handler\Mapping\FailedToMapCommand;
use League\Tactician\Handler\Mapping\MapByStaticList;
use League\Tactician\Tests\Fixtures\Command\AddTaskCommand;
use League\Tactician\Tests\Fixtures\Command\CompleteTaskCommand;
use League\Tactician\Tests\Fixtures\Handler\ConcreteMethodsHandler;
use PHPUnit\Framework\TestCase;

class MappingByStaticListTest extends TestCase
{
    public function testSuccessfulMapping(): void
    {
        $mapping = new MapByStaticList(
            [
                AddTaskCommand::class => [ConcreteMethodsHandler::class, 'handle'],
            ]
        );

        static::assertEquals(
            ConcreteMethodsHandler::class,
            $mapping->getClassName(AddTaskCommand::class)
        );
        static::assertEquals('handle', $mapping->getMethodName(AddTaskCommand::class));
    }

    public function testFailedClassNameMapping(): void
    {
        $mapping = new MapByStaticList(
            [
                AddTaskCommand::class => [ConcreteMethodsHandler::class, 'handle'],
            ]
        );

        $this->expectExceptionObject(FailedToMapCommand::className(CompleteTaskCommand::class));
        $mapping->getClassName(CompleteTaskCommand::class);
    }

    public function testFailedMethodNameMapping(): void
    {
        $mapping = new MapByStaticList(
            [
                AddTaskCommand::class => [ConcreteMethodsHandler::class, 'handle'],
            ]
        );

        $this->expectExceptionObject(FailedToMapCommand::methodName(CompleteTaskCommand::class));
        $mapping->getMethodName(CompleteTaskCommand::class);
    }
}
