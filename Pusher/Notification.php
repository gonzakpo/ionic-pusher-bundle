<?php

namespace Draw\IonicPusherBundle\Pusher;

class Notification implements \JsonSerializable
{
    const PRIORITY_NORMAL = 'normal';
    const PRIORITY_HIGH = 'high';

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
     * The name of a sound resource to use for the notification. If not present,
     * the default notification sound will be used.
     *
     * @var string
     */
    private $sound;

    /**
     * Android specific notification data
     *
     * @var AndroidNotification
     */
    private $android;

    /**
     * Ios specific notification data
     *
     * @var IosNotification
     */
    private $ios;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Notification
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
     * @return Notification
     */
    public function setMessage($message)
    {
        $this->message = $message;

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
     * @return Notification
     */
    public function setSound($sound)
    {
        $this->sound = $sound;

        return $this;
    }

    public function setPayload(array $payload = null)
    {
        $this->getAndroid()->setPayload($payload);
        $this->getIos()->setPayload($payload);

        return $this;
    }

    /**
     * @return AndroidNotification
     */
    public function getAndroid()
    {
        if(is_null($this->android)) {
            $this->android = new AndroidNotification($this);
        }

        return $this->android;
    }

    /**
     * @return IosNotification
     */
    public function getIos()
    {
        if(is_null($this->ios)) {
            $this->ios = new IosNotification($this);
        }

        return $this->ios;
    }

    public function setPriority($priority)
    {
        $this->getAndroid()->setPriority($priority);
        $this->getIos()->setPriority($priority);

        return $this;
    }

    /**
     * Set a expiration delay compatible with strtotime
     *
     * @param $delay
     */
    public function setExpirationDelay($delay)
    {
        $this->getAndroid()->setExpirationDelay($delay);
        $this->getIos()->setExpirationDelay($delay);

        return $this;
    }

    public function jsonSerialize()
    {
        $result = [];
        foreach($this as $key => $value) {
            $result[$key] = $value;
        }

        return array_filter($result, function($value) {
            return !is_null($value);
        });
    }

    static public function create($title = null, $message = null, array $payload = null)
    {
        $notification = new static();
        $notification->title = $title;
        $notification->message = $message;
        if($payload) {
            $notification->setPayload($payload);
        }

        return $notification;
    }
}