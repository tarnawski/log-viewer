<?php

namespace spec\LogViewerBundle\DataTransformer\Strategy;

use LogViewerBundle\DataTransformer\TransformStrategy;
use LogViewerBundle\Model\LogCollection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StringStrategySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('LogViewerBundle\DataTransformer\Strategy\StringStrategy');
        $this->shouldImplement(TransformStrategy::class);
    }

    function it_should_create_log_collection()
    {
        $data = [
            '[2016-06-01 22:02:16] php.INFO: Not quoting the scalar "@doctrine.orm.entity_manager" starting with "@" is deprecated since Symfony 2.8 and will throw a ParseException in 3.0. {"type":16384,"file":"/var/www/JSONMock/vendor/symfony/symfony/src/Symfony/Component/Yaml/Inline.php","line":241,"level":28928} []',
            '[2016-06-01 22:02:16] php.INFO: Not quoting the scalar "@doctrine.orm.entity_manager" starting with "@" is deprecated since Symfony 2.8 and will throw a ParseException in 3.0. {"type":16384,"file":"/var/www/JSONMock/vendor/symfony/symfony/src/Symfony/Component/Yaml/Inline.php","line":241,"level":28928} []'
        ];

        $result = $this->transform($data);

        $result->shouldReturnAnInstanceOf(LogCollection::class);
        $result->getLogs()->shouldHaveCount(2);
    }
}
