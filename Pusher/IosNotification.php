<?php

namespace Draw\IonicPusherBundle\Pusher;


class IosNotification implements \JsonSerializable
{
    /**
     * @var Notification
     */
    private $parentNotification;

    /**
     * The title of the notification
     *
     * @var string
     */
    private $title;

    /**
     * The message of the notification
     *
     * @var string
     */
    private $message;

    /**
     * You can add custom key/value data to your notifications with the payload key as follows.
     *
     * @var array
     */
    private $payload;

    /**
     * The name of a sound resource to use for the notification. If not present,
     * the default notification sound will be used.
     *
     * @var string
     */
    private $sound;

    /**
     * The badge number to set on the application's icon.
     *
     * @var string
     */
    private $badge;

    /**
     * Specify priority as 5 or 10. 10 will attempt to deliver the notification immediately (or immediately after it was
     * scheduled. 5 will attempt to deliver the notification at a time which conserves device battery power.
     *
     * @var integer
     */
    private $priority;

    /**
     * You can specify TTL's on your notifications, creating times after which APN will no longer attempt to send them.
     * RFC 3339 format
     *
     * @var string
     */
    private $expire;

    /**
     * You may wish to send silent pushes, which will silently wake up your application to do some sort of processing in
     * the background. Tis is accomplished with the content_available key to 1.
     *
     * @var integer
     */
    private $content_available;

    /**
     * IosNotification constructor.
     * @param Notification $parentNotification
     */
    public function __construct(Notification $parentNotification)
    {
        $this->parentNotification = $parentNotification;
    }

    /**
     * @return Notification
     */
    public function getParentNotification()
    {
        return $this->parentNotification;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return IosNotification
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return IosNotification
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return array
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * @param array $payload
     * @return IosNotification
     */
    public function setPayload(array $payload = null)
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * @return string
     */
    public function getSound()
    {
        return $this->sound;
    }

    /**
     * @param string $sound
     * @return IosNotification
     */
    public function setSound($sound)
    {
        $this->sound = $sound;

        return $this;
    }

    /**
     * @return string
     */
    public function getBadge()
    {
        return $this->badge;
    }

    /**
     * @param string $badge
     * @return IosNotification
     */
    public function setBadge($badge)
    {
        $this->badge = $badge;

        return $this;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     * @return IosNotification
     */
    public function setPriority($priority)
    {
        if($priority == Notification::PRIORITY_HIGH) {
            $priority = 10;
        }

        if($priority == Notification::PRIORITY_NORMAL) {
            $priority = 5;
        }

        $this->priority = $priority;

        return $this;
    }

    /**
     * @return string
     */
    public function getExpire()
    {
        return $this->expire;
    }

    /**
     * @param string $expire
     * @return IosNotification
     */
    public function setExpire($expire)
    {
        $this->expire = $expire;

        return $this;
    }

    /**
     * @return int
     */
    public function getContentAvailable()
    {
        return $this->content_available;
    }

    /**
     * @param int $content_available
     * @return IosNotification
     */
    public function setContentAvailable($content_available)
    {
        $this->content_available = $content_available;

        return $this;
    }

    /**
     * Set a expiration delay compatible with strtotime
     *
     * @param $delay
     * @return $this
     */
    public function setExpirationDelay($delay)
    {
        $dateTime = new \DateTime($delay);
        $this->setExpire($dateTime->format(\DateTime::RFC3339));

        return $this;
    }

    public function jsonSerialize()
    {
        $result = [];
        foreach($this as $key => $value) {
            $result[$key] = $value;
        }

        unset($result['parentNotification']);

        return array_filter($result, function($value) {
            return !is_null($value);
        });
    }
}