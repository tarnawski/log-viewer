<?php

namespace spec\LogViewerBundle\Reader;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LogReaderSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(100);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('LogViewerBundle\Reader\LogReader');
    }

    function it_should_explode_logs()
    {
        $data = 'LOG1\nLOG2\nLOG3';

        $result = $this->explodeLogs($data);

        $result->shouldBeArray();
    }
}
