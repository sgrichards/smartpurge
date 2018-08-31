<?php
/**
 * SmartPurge API - Factory.
 */

namespace SmartPurge;

/**
 * Factory class for SmartPurge.
 */
class SmartPurgeFactory
{

    /**
     * Build new SmartPurger.
     *
     * @param string $username
     * @param string $sharedKey
     * @param string $shortName
     *
     * @return SmartPurge
     */
    public static function build(string $username, string $sharedKey, string $shortName) {
        return new SmartPurge($username, $sharedKey, $shortName);
    }

}
