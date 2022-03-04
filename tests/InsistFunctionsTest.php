<?php

declare(strict_types=1);

namespace nicoorfi\insist;

use Exception;

use function Nicoorfi\Insist\insist_fibonnaci;

class InsistFunctionsTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function callable_is_called()
    {
        $shouldBeCalled = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['__invoke'])
            ->getMock();

        $shouldBeCalled->expects($this->once())
            ->method('__invoke');

        insist_fibonnaci($shouldBeCalled, 5000000, 0);
    }

    /**
     * @test
     */
    public function exception_is_thrown()
    {
        $shouldBeCalled = $this->getMockBuilder(\stdClass::class)
            ->addMethods(['__invoke'])
            ->getMock();
        $shouldBeCalled->method('__invoke')->willThrowException(new Exception());

        $this->expectException(Exception::class);

        insist_fibonnaci($shouldBeCalled, 5000000, 0);
    }
}
