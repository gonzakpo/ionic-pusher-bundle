<?php

namespace Draw\IonicPusherBundle\Pusher;

use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

class Pusher
{
    /**
     * A jwt authentication token
     *
     * @var string
     */
    private $authToken;

    /**
     * @var Client
     */
    private $client;

    private $defaultProfile;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct($authToken, $defaultProfile = null)
    {
        $this->authToken = $authToken;
        $this->defaultProfile = $defaultProfile;
        $this->verifyAuthToken();
    }

    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return string
     */
    public function getDefaultProfile()
    {
        return $this->defaultProfile;
    }

    /**
     * @return Client
     */
    private function getClient()
    {
        if (is_null($this->client)) {
            $this->client = new Client(
                [
                    'base_uri' => 'https://api.ionic.io',
                    'headers' => [
                        'Authorization' => sprintf("Bearer %s", $this->authToken),
                       // 'Content-Type' => 'application/json'
                    ]
                ]
            );
        }

        return $this->client;
    }

    public function getAuthToken()
    {
        return $this->authToken;
    }

    public function sendPushNotification(PushNotification $pushNotification)
    {
        if(!$pushNotification->getProfile()) {
            $pushNotification->setProfile($this->defaultProfile);
        }

        $this->logger && $this->logger->debug('Pusher send push notification', ['pushNotification' => json_decode(json_encode($pushNotification), true)]);

        $response = $this->getClient()
            ->post('/push/notifications',
                [
                    'json' => $pushNotification
                ]
            );
        return json_decode($response->getBody()->getContents());
    }

    public function testApiAccess()
    {
        return $this->getClient()->get('/auth/test') ? true : false;
    }

    private function verifyAuthToken()
    {
        if (!$this->authToken) {
            throw new \InvalidArgumentException(
                'Auth token is not a valid JWT. Please check you are using the correct token'
            );
        }
        $parts = explode('.', $this->authToken);
        if (!is_object(json_decode(base64_decode($parts[0]))) && is_object(json_decode(base64_decode($parts[1])))) {
            throw new \InvalidArgumentException(
                'Auth token is not a valid JWT. Please check you are using the correct token'
            );
        }
    }

    public function getNotificationStatus($uuid)
    {
        return json_decode(
            $this->getClient()->get('/push/notifications/' . $uuid . '/messages')->getBody()->getContents(),
            true
        );
    }
}