<?php

namespace LogViewerBundle\Reader;

use LogViewerBundle\Exception\ReaderException;

class LogReader
{
    /** @var  integer */
    public $maxTail;

    public function __construct($maxTail)
    {
        $this->maxTail = $maxTail;
    }

    public function readData($path)
    {
        $data = $this->getTail($path);
        $arrayData = $this->explodeLogs($data);

        return $arrayData;
    }

    public function getTail($path)
    {
        $file = @fopen($path, "rb");
        if ($file === false) {
            throw new ReaderException('File not found!');
        }
        $buffer = ($this->maxTail < 2 ? 64 : ($this->maxTail < 10 ? 512 : 4096));
        fseek($file, -1, SEEK_END);
        if (fread($file, 1) != "\n") $this->maxTail -= 1;
        $output = '';
        $chunk = '';
        while (ftell($file) > 0 && $this->maxTail >= 0) {
            $seek = min(ftell($file), $buffer);
            fseek($file, -$seek, SEEK_CUR);
            $output = ($chunk = fread($file, $seek)) . $output;
            fseek($file, -mb_strlen($chunk, '8bit'), SEEK_CUR);
            $this->maxTail -= substr_count($chunk, "\n");
        }

        while ($this->maxTail++ < 0) {
            $output = substr($output, strpos($output, "\n") + 1);
        }
        fclose($file);


        return trim($output);
    }

    public function explodeLogs($data)
    {
        $lines = explode("\n", $data);
        $reverseLines = array_reverse($lines);

        return $reverseLines;
    }
}