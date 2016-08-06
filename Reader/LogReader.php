<?php

namespace LogViewerBundle\Reader;

class LogReader
{
    /** @var  integer */
    public $lines;

    public function __construct($lines)
    {
        $this->lines = $lines;
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
            return false;
        }
        $buffer = ($this->lines < 2 ? 64 : ($this->lines < 10 ? 512 : 4096));
        fseek($file, -1, SEEK_END);
        if (fread($file, 1) != "\n") $this->lines -= 1;
        $output = '';
        $chunk = '';
        while (ftell($file) > 0 && $this->lines >= 0) {
            $seek = min(ftell($file), $buffer);
            fseek($file, -$seek, SEEK_CUR);
            $output = ($chunk = fread($file, $seek)) . $output;
            fseek($file, -mb_strlen($chunk, '8bit'), SEEK_CUR);
            $this->lines -= substr_count($chunk, "\n");
        }

        while ($this->lines++ < 0) {
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