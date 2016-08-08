<?php

namespace LogViewerBundle\Model;

class Log
{
    /** @var string */
    private $message;

    /** @var string */
    private $context;

    /** @var integer */
    private $level;

    /** @var string */
    private $channel;

    /** @var \DateTime */
    private $dateTime;

    public function __construct($message, $context, $level, $channel, $dateTime)
    {
        $this->message = $message;
        $this->context = $context;
        $this->level = $level;
        $this->channel = $channel;
        $this->dateTime = $dateTime;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @return string
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @return \DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }
}