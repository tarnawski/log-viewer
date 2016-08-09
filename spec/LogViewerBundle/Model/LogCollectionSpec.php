<?php

namespace spec\LogViewerBundle\Model;

use LogViewerBundle\Model\Log;
use LogViewerBundle\Model\LogCollection;
use LogViewerBundle\Model\LogCriteria;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LogCollectionSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('LogViewerBundle\Model\LogCollection');
    }

    function it_should_add_and_return_logs(Log $log) {
        $this->addLog($log);
        $this->addLog($log);

        $result = $this->getLogs();

        $result->shouldBeArray();
        $result->shouldHaveCount(2);
    }

    function it_should_filter_logs_by_level(
        Log $log1,
        Log $log2,
        LogCriteria $criteria
    ) {
        $log1->getLevel()->willReturn('ERROR');
        $log2->getLevel()->willReturn('DEBUG');
        $criteria->level = 'ERROR';
        $this->addLog($log1);
        $this->addLog($log2);

        $result = $this->filterLogs($criteria);

        $result->shouldBeArray();
        $result->shouldHaveCount(1);
    }

    function it_should_filter_logs_by_date(
        Log $log1,
        Log $log2,
        LogCriteria $criteria
    ) {
        $now = new \DateTime();
        $log1->getDateTime()->willReturn($now->modify('-5 day'));
        $now = new \DateTime();
        $log2->getDateTime()->willReturn($now->modify('-1 day'));
        $now = new \DateTime();
        $criteria->date = $now->modify('-2 day');
        $this->addLog($log1);
        $this->addLog($log2);

        $result = $this->filterLogs($criteria);

        $result->shouldBeArray();
        $result->shouldHaveCount(1);
    }

    function it_should_filter_logs_by_message(
        Log $log1,
        Log $log2,
        LogCriteria $criteria
    ) {
        $log1->getMessage()->willReturn('Content1');
        $log2->getMessage()->willReturn('Content2');
        $criteria->message = 'Content1';
        $this->addLog($log1);
        $this->addLog($log2);

        $result = $this->filterLogs($criteria);

        $result->shouldBeArray();
        $result->shouldHaveCount(1);
    }

    function it_should_filter_logs_by_limit(
        Log $log1,
        Log $log2,
        Log $log3,
        LogCriteria $criteria
    ) {
        $this->addLog($log1);
        $this->addLog($log2);
        $this->addLog($log3);
        $criteria->limit = 2;

        $result = $this->filterLogs($criteria);

        $result->shouldBeArray();
        $result->shouldHaveCount(2);
    }
}
