<?php

namespace LogViewerBundle\DataTransformer;

use LogViewerBundle\Model\LogCollection;

interface TransformStrategy
{
    /**
     * @param array $data
     * @return LogCollection
     */
    public function transform(array $data);
}
