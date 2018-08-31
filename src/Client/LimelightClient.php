<?php
/**
 * LimelightClient.
 */

namespace SmartPurge\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;
use SmartPurge\Pattern;
use SmartPurge\Tag;
use SmartPurge\SmartPurgeException;

/**
 * Class LimelightClient
 * @package SmartPurge\Client
 */
class LimelightClient
{

    // Defaults.
    const LL_HOST = 'https://purge.llnw.com';
    const LL_ENDPOINT = '/purge/v1/account/';
    const LL_VERSION = '1';
    const LL_PATH_PURGE_REQUEST = '/requests';

    /**
     * @var Client
     */
    private $guzzleClient;

    /**
     * Create a LimelightClient.
     *
     * @param string $username
     * @param string $sharedKey
     * @param string $shortName
     *
     * @return LimelightClient
     */
    public static function build(string $username, string $sharedKey, string $shortName)
    {
        return new self($username, $sharedKey, $shortName);
    }

    /**
     * @param string $username
     * @param string $sharedKey
     * @param string $shortName
     */
    private function __construct(string $username, string $sharedKey, string $shortName)
    {
        // Assign credentials.
        $this->username = $username;
        $this->sharedKey = $sharedKey;
        $this->shortName = $shortName;

        // Assign defaults.
        $this->host = self::LL_HOST;
        $this->endpoint = self::LL_ENDPOINT;
        $this->version = self::LL_VERSION;

        // Assemble uri.
        $this->uri = self::LL_HOST . self::LL_ENDPOINT . $this->shortName . self::LL_PATH_PURGE_REQUEST;

        $this->guzzleClient = new Client();
    }

    /**
     * Make a SmartPurge API request via GuzzleHttp client.
     *
     * @param string $method
     * @param Pattern[] $patterns
     * @param Tag[] $tags
     *
     * @return bool|ResponseInterface
     * @throws SmartPurgeException
     */
    public function request($method = 'GET', array $patterns = [], array $tags = [])
    {
        try {
            $tags ?: $data['tags'] = $tags;
            $patterns ?: $data['patterns'] = $patterns;

            $dataJson = json_encode($data);
            $dataJson = str_replace('\/', '/', $dataJson);

            $clientOpts = $this->getClientOpts($method, $this->uri, '', $dataJson);

            return $this->guzzleClient->request($method, $this->uri, $clientOpts);
        }
        catch(GuzzleException $e) {
            throw new SmartPurgeException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Create request options for Limelight Api to be sent to Guzzle client
     *
     * @param string $method Http Method (GET | POST)
     * @param string|null $path Api path
     * @param string $params Query parameters
     * @param string $data Raw post data
     *
     * @return array Api request options
     */
    private function getClientOpts(string $method, string $path, string $params = '', string $data): array
    {
        $headers = $this->getHeaders($method, $path, $params, $data);
        $httpOpts = [
            'headers' => $headers
        ];

        if ('POST' == $method && !empty($data)) {
            $httpOpts['body'] = $data;
        }

        return $httpOpts;
    }

    /**
     * Create request headers for Limelight Api
     *
     * @param string $method Http Method (GET | POST)
     * @param string $path   Api path. For example, '/request'
     * @param string $params Query parameters
     * @param string $data   Raw post data
     *
     * @return array Api request headers
     */
    private function getHeaders($method, $path, $params = '', $data): array
    {
        $timestamp = $this->getTimestamp();
        $mac = $this->getMac($method, $path, $params, $timestamp, $data);

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'X-LLNW-Security-Token' => $mac,
            'X-LLNW-Security-Principal' => $this->username,
            'X-LLNW-Security-Timestamp' => $timestamp
        ];

        if ('POST' == $method && !empty($data)) {
            $headers['Content-Length'] = strlen($data);
        }

        return $headers;
    }

    /**
     * Get system time in milliseconds
     *
     * @return string System time as a string
     */
    private function getTimestamp(): string
    {
        return number_format(time() * 1000, 0, '.', '');
    }

    /**
     * Generate MAC hash from the following data:
     *
     *   REQUEST_METHOD + URL + QUERY_STRING (if present) + TIMESTAMP + REQUEST_BODY (id present).
     *
     * @param string $method Http Method. (GET | POST)
     * @param string $url API path.
     * @param string $params Query string.
     * @param string $timestamp System time in milliseconds.
     * @param string $data Request body.
     *
     * @return string MAC hash digest
     */
    private function getMac($method, $url, $params = '', $timestamp, $data = ''): string
    {
        $dataString = $method . $url . $params . $timestamp . $data;

        // Generate hash.
        $mac = $this->generateMac($this->sharedKey, $dataString);

        return $mac;
    }

    /**
     * Generate MAC hash digest for the given data string
     *
     * @param string $sharedKey  User shared key
     * @param string $dataString Combined dataString
     *
     * @return string Hash digest
     */
    private function generateMac($sharedKey, $dataString): string
    {
        $dataKey = pack('H*', $sharedKey);

        return hash_hmac('sha256', $dataString, "$dataKey");
    }

}