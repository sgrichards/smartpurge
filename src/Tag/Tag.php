<?php

namespace SmartPurge\Tag;

/**
 * Class Tag
 * @package SmartPurge
 */
class Tag
{
    /**
     * @var string $tag
     */
    public $tag;

    /**
     * @var bool $evict
     */
    public $evict;

    function __construct(string $tag, $evict = false)
    {
        $this->tag = $tag;
        $this->evict = $evict;
    }

}
