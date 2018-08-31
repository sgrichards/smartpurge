<?php
/**
 * SmartPurge API - Purge.
 */

namespace SmartPurge;

use SmartPurge\Client\LimelightClient;
use SmartPurge\Pattern\Pattern;
use SmartPurge\Tag\Tag;

/**
 * SmartPurge.
 */
class SmartPurge
{
    /**
     * Limelight API client.
     *
     * @var LimelightClient
     */
    private $limelightClient;

    /**
     * SmartPurge constructor.
     *
     * @param string $username
     * @param string $sharedKey
     * @param string $shortName
     */
    public function __construct(string $username, string $sharedKey, string $shortName)
    {
        $this->limelightClient = LimelightClient::build($username, $sharedKey, $shortName);
    }

    /**
     * Make a purge request.
     *
     * @param Pattern[] $patterns
     * @param Tag[] $tags
     *
     * @return bool|string
     */
    public function purge(array $patterns = [], array $tags = [])
    {
        try {
            $response = $this->limelightClient->request('POST', $patterns, $tags);
            $responseArray = json_decode($response->getBody(), true);

            return $responseArray['id'];
        }
        catch(SmartPurgeException $e) {
            return FALSE;
        }
    }

    /**
     * Create a pattern object.
     *
     * @param string $pattern
     * @param bool $evict
     * @param bool $exact
     * @param bool $incqs
     *
     * @return Pattern
     */
    public function getPattern(string $pattern, bool $evict = false, bool $exact = false, bool $incqs = false): Pattern
    {
        return new Pattern($pattern, ['evict' => $evict, 'exact' => $exact, 'incqs' => $incqs]);
    }

    /**
     * Create a tag object.
     *
     * @param string $tag
     * @param bool $evict
     *
     * @return Tag
     */
    public function getTag(string $tag, bool $evict = false): Tag
    {
        return new Tag($tag, $evict);
    }
}