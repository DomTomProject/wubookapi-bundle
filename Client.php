<?php

namespace Kamwoz\WubookAPIBundle;

use Kamwoz\WubookAPIBundle\Handler\TokenHandler;
use Kamwoz\WubookAPIBundle\Utils\TokenProviderInterface;
use PhpXmlRpc\Encoder;
use PhpXmlRpc\Request;
use PhpXmlRpc\Value;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

/**
 * Responsibility: perform request to wubook API
 * @package AppBundle\Service\WubookAPI
 */
class Client {

    /**
     * @var string url target
     */
    private $apiUrl;

    /**
     * @var int property unique id
     */
    private $propertyId;

    /**
     * @var array credentials used to acquire the token
     */
    public $credentials = [];

    /**
     * @var TokenHandler
     */
    private $tokenHandler;

    /**
     * @var TokenProviderInterface
     */
    public $tokenProvider;
    private $env;
    private $methodWhitelist = [
        'acquire_token', 'release_token', 'is_token_valid', 'provider_info',
        'fetch_rooms', 'room_images', 'new_reservation', 'fetch_bookings',
        'fetch_booking', 'fetch_rooms_values', 'cancel_reservation', 'update_avail',
        'update_sparse_avail', 'fetch_new_bookings', 'new_room', 'mod_room', 'del_room',
        'push_activation', 'mark_bookings', 'push_url', 'push_update_activation', 'push_update_url',
    ];

    /**
     * @param TokenProviderInterface $tokenProvider
     * @param $apiUrl
     * @param $propertyId
     */
    public function __construct(TokenProviderInterface $tokenProvider, $apiUrl, $env) {
        $this->tokenProvider = $tokenProvider;
        $this->apiUrl = $apiUrl;
        $this->env = $env;

        if (!function_exists('curl_version')) {
            throw new \Exception('cURL is not installed');
        }
    }

    public function setPropertyId(string $propertyId) {
        $this->propertyId = $propertyId;
    }
    
    public function isDisabled(): bool{
        return $this->env === 'test';
    }

    /**
     * Perform request to wubook api
     *
     * @param $method
     * @param $args                array, NOTICE: order is important here
     * @param bool $passToken      true if you want pass token as first parameter
     * @param bool $passPropertyId true if you want pass property id as second parameter
     * @param bool $tryAcquireNewToken
     *
     * @return mixed|Value|string
     * @internal param bool|true $useToken true if you want use token from config
     */
    public function request($method, array $args, $passToken = true, $passPropertyId = true, $tryAcquireNewToken = true) {
        if ($this->isDisabled()) {
            return null;
        }

        if (!in_array($method, $this->methodWhitelist)) {
            throw new MethodNotAllowedException($this->methodWhitelist, 'Method "' . $method . '" not allowed, allowed: ' . join(', ', $this->methodWhitelist));
        }

        $requestArgs = $passToken ? [$this->tokenProvider->getToken()] : [];
        if ($passPropertyId) {
            $requestArgs[] = (string) $this->propertyId;
        }

        $encoder = new Encoder();
        $requestData = [];
        foreach (array_merge($requestArgs, $args) as $arg) {
            $requestData[] = $encoder->encode($arg);
        }

        $server = new \PhpXmlRpc\Client($this->apiUrl);
        $request = new Request($method, $requestData);
        $response = $server->send($request);

        $isResponseOK = !empty($response->value()) && (int) $response->value()->me['array'][0]->scalarval() == 0;
        if (!$isResponseOK && $tryAcquireNewToken) {
            if ($this->tokenHandler->isCurrentTokenValid()) {
                return $response;
            }

            $this->tokenHandler->acquireToken();
            return self::request($method, $args, $passToken, $passPropertyId, false);
        }

        return $response;
    }

    public function setTokenHandler(TokenHandler $tokenHandler) {
        $this->tokenHandler = $tokenHandler;
    }

}
