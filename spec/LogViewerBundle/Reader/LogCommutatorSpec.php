<?php

namespace spec\LogViewerBundle\Reader;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LogCommutatorSpec extends ObjectBehavior
{
    function let()
    {
        $logsConf = [
          'conf1' => [
              'path' => 'dev.log',
              'method' => 'json'
          ],
          'conf2' => [
              'path' => 'test.log',
              'method' => 'string'
          ]
        ];
        $this->beConstructedWith($logsConf);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('LogViewerBundle\Reader\LogCommutator');
    }

    function it_should_get_first_configuration()
    {
        $result = $this->getConfiguration('default');

        $result->shouldBeArray();
        $result->shouldHaveKeyWithValue('path', 'dev.log');
        $result->shouldHaveKeyWithValue('method', 'json');
    }

    function it_should_get_configuration()
    {
        $result = $this->getConfiguration('conf2');

        $result->shouldBeArray();
        $result->shouldHaveKeyWithValue('path', 'test.log');
        $result->shouldHaveKeyWithValue('method', 'string');
    }
}
