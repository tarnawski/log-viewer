<?php

namespace spec\LogViewerBundle\DataTransformer\Strategy;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use LogViewerBundle\DataTransformer\TransformStrategy;
use LogViewerBundle\Model\LogCollection;

class JsonStrategySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('LogViewerBundle\DataTransformer\Strategy\JsonStrategy');
        $this->shouldImplement(TransformStrategy::class);
    }

    function it_should_create_log_collection()
    {
        $data = [
            '{"message":"POST \/monitorsd?test=1","context":[],"level":200,"level_name":"INFO","channel":"app","datetime":{"date":"2015-07-12 05:31:09.128946","timezone_type":3,"timezone":"UTC"},"extra":{"uid":"9341e5e"}}',
            '{"message":"POST \/monitors\/55a183c5b219b1290d8b4567\/checks","context":[],"level":200,"level_name":"INFO","channel":"app","datetime":{"date":"2015-07-12 05:36:45.889520","timezone_type":3,"timezone":"UTC"},"extra":{"uid":"763b463"}}'
        ];

        $result = $this->transform($data);

        $result->shouldReturnAnInstanceOf(LogCollection::class);
        $result->getLogs()->shouldHaveCount(2);
    }
}
