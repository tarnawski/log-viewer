<?php

namespace LogViewerBundle\DataTransformer;

use LogViewerBundle\Exception\DataTransformerException;

class StrategyFactory
{
    public $stringStrategy;
    public $jsonStrategy;
    public $method;

    const STRING_STRATEGY = 'string';
    const JSON_STRATEGY = 'json';

    public function __construct(
        $method,
        TransformStrategy $stringStrategy,
        TransformStrategy $jsonStrategy
    ) {
        $this->method = $method;
        $this->stringStrategy = $stringStrategy;
        $this->jsonStrategy = $jsonStrategy;
    }

    public function getDefaultStrategy()
    {
        return $this->getStrategy($this->method);
    }

    public function getStrategy($method)
    {
        switch ($method) {
            case self::STRING_STRATEGY:
                return $this->stringStrategy;
                break;
            case self::JSON_STRATEGY:
                return $this->jsonStrategy;
                break;
            default:
                throw new DataTransformerException('Method "'.$method.'" not found!');
        }
    }
}
