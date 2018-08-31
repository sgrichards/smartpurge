<?php

namespace SmartPurge\Pattern;

/**
 * Class Pattern
 * @package SmartPurge
 */
class Pattern
{
    const LL_EVICT = 'evict';
    const LL_EXACT = 'exact';
    const LL_INCQS = 'incqs';

    /**
     * @var string $pattern
     */
    public $pattern;

    /**
     * @var bool $evict
     */
    public $evict;

    /**
     * @var bool $exact
     */
    public $exact;

    /**
     * @var bool $incqs
     */
    public $incqs;

    function __construct(string $pattern, array $config = [])
    {
        $this->pattern = $pattern;
        $this->evict = isset($config[self::LL_EVICT]) ? $config[self::LL_EVICT] : FALSE;
        $this->exact = isset($config[self::LL_EXACT]) ? $config[self::LL_EXACT] : FALSE;
        $this->incqs = isset($config[self::LL_INCQS]) ? $config[self::LL_INCQS] : FALSE;
    }

}
