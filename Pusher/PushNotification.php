<?php

namespace Draw\IonicPusherBundle\Pusher;


class PushNotification implements \JsonSerializable
{
    /**
     * @var string[]
     */
    private $tokens;

    /**
     * @var string[]
     */
    private $user_ids;

    /**
     * @var <string,string[]>
     */
    private $providersIds = [];

    /**
     * The profile to use
     *
     * @var string
     */
    private $profile;

    /**
     * @var Notification
     */
    private $notification;

    /**
     * To schedule the notification for later. A date in the RFC 3339 format
     *
     * @var string
     */
    private $scheduled;

    /**
     * @return \string[]
     */
    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * @param \string[] $tokens
     * @return PushNotification
     */
    public function setTokens($tokens)
    {
        $this->tokens = $tokens;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getUserIds()
    {
        return $this->user_ids;
    }

    /**
     * @param \string[] $user_ids
     * @return PushNotification
     */
    public function setUserIds($user_ids)
    {
        $this->user_ids = $user_ids;

        return $this;
    }

    public function setProviderIds($provider, array $ids = null)
    {
        $this->providersIds[$provider] = $ids;
    }

    /**
     * @param $provider
     * @return string[]|null
     */
    public function getProviderIds($provider)
    {
        return array_key_exists($provider, $this->providersIds) ? $this->providersIds[$provider] : null;
    }

    /**
     * @return string
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * @param string $profile
     * @return PushNotification
     */
    public function setProfile($profile)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * @return Notification
     */
    public function getNotification()
    {
        if(is_null($this->notification)) {
            $this->notification = new Notification();
        }

        return $this->notification;
    }

    /**
     * @param Notification $notification
     * @return PushNotification
     */
    public function setNotification($notification)
    {
        $this->notification = $notification;

        return $this;
    }

    /**
     * @return string
     */
    public function getScheduled()
    {
        return $this->scheduled;
    }

    /**
     * @param string $scheduled
     * @return PushNotification
     */
    public function setScheduled($scheduled)
    {
        $dateTime = new \DateTime($scheduled);

        $this->scheduled = $dateTime->format(\DateTime::RFC3339);

        return $this;
    }

    public function jsonSerialize()
    {
        $result = [];
        foreach($this as $key => $value) {
            $result[$key] = $value;
        }

        $result = array_filter($result, function($value) {
           return !is_null($value);
        });

        foreach($result['providersIds'] as $provider => $ids) {
            $result[$provider . '_ids'] = $ids;
        }

        unset($result['providersIds']);

        return $result;
    }

    /**
     * @return static
     */
    public static function create()
    {
        return new static();
    }

    /**
     * @param array $tokens
     * @param $title
     * @param null $message
     * @param array|null $payload
     *
     * @return PushNotification
     */
    public static function simpleCreate(array $tokens, $title, $message = null, array $payload = null)
    {
        return static::create()
            ->setTokens($tokens)
            ->setNotification(Notification::create($title, $message, $payload));
    }
}