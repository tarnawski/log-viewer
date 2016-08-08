<?php

namespace spec\LogViewerBundle\DataTransformer;

use LogViewerBundle\DataTransformer\Strategy\JsonStrategy;
use LogViewerBundle\DataTransformer\Strategy\StringStrategy;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use LogViewerBundle\Exception\DataTransformerException;

class StrategyFactorySpec extends ObjectBehavior
{
    public function let(
        StringStrategy $stringStrategy,
        JsonStrategy $jsonStrategy
    ) {
        $this->beConstructedWith('string', $stringStrategy, $jsonStrategy);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('LogViewerBundle\DataTransformer\StrategyFactory');
    }

    function it_should_return_default_method(StringStrategy $stringStrategy)
    {
        $this->getDefaultStrategy()->shouldReturn($stringStrategy);
    }

    function it_should_return_correctly_method(JsonStrategy $jsonStrategy)
    {
        $this->getStrategy('json')->shouldReturn($jsonStrategy);
    }

    function it_should_return_throw_when_method_not_correct()
    {
        $this->shouldThrow(DataTransformerException::class)->during('getStrategy',['invalid'] );
    }
}
