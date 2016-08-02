<?php

namespace Draw\IonicPusherBundle\Pusher;


class AndroidNotification implements \JsonSerializable
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
     * The icon to use for your push notification.
     *
     * @var string
     */
    private $icon;

    /**
     * The color to display your icon in the notification drawer. Must be in hex format #rrggbb
     *
     * @var string
     */
    private $icon_color;

    /**
     * This parameter identifies a group of messages (e.g., with collapse_key: "Updates Available")
     * that can be collapsed, so that only the last message gets sent when delivery can be resumed.
     *
     * @var string
     */
    private $collapse_key;

    /**
     * Indicates whether each notification message results in a new entry on the notification center.
     * If not set, each request creates a new notification. If set, and a notification with the same tag
     * is already being shown, the new notification replaces the existing one.
     *
     * @var string
     */
    private $tag;

    /**
     * Specify priority as high or normal. high will attempt to deliver the notification immediately (or immediately after
     * it was scheduled. normal will attempt to deliver the notification at a time which conserves device battery power.
     *
     * @var string
     */
    private $priority;

    /**
     * You can specify TTL's on your notifications, creating times after which GCM ll no longer attempt to send them.
     * The value is in seconds
     *
     * @var integer
     */
    private $time_to_live;

    /**
     * You can tell GCM to delay the delivery of a notification until the target device is active
     *
     * @var boolean
     */
    private $delay_while_idle;

    /**
     * You may wish to send silent pushes, which will silently wake up your application to do some sort of processing in
     * the background. Tis is accomplished with the content_available key to 1.
     *
     * @var integer
     */
    private $content_available;

    /**
     * @var array
     */
    private $data;

    /**
     * AndroidNotification constructor.
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
     * @return AndroidNotification
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
     * @return AndroidNotification
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
     * @return AndroidNotification
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
     * @return AndroidNotification
     */
    public function setSound($sound)
    {
        $this->sound = $sound;

        return $this;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     * @return AndroidNotification
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return string
     */
    public function getIconColor()
    {
        return $this->icon_color;
    }

    /**
     * @param string $icon_color
     * @return AndroidNotification
     */
    public function setIconColor($icon_color)
    {
        $this->icon_color = $icon_color;

        return $this;
    }

    /**
     * @return string
     */
    public function getCollapseKey()
    {
        return $this->collapse_key;
    }

    /**
     * @param string $collapse_key
     * @return AndroidNotification
     */
    public function setCollapseKey($collapse_key)
    {
        $this->collapse_key = $collapse_key;

        return $this;
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     * @return AndroidNotification
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return string
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param string $priority
     * @return AndroidNotification
     */
    public function setPriority($priority)
    {
        if($priority == 10) {
            $priority = Notification::PRIORITY_HIGH;
        }

        if($priority == 5) {
            $priority = Notification::PRIORITY_NORMAL;
        }

        $this->priority = $priority;

        return $this;
    }

    /**
     * @return int
     */
    public function getTimeToLive()
    {
        return $this->time_to_live;
    }

    /**
     * @param int $time_to_live
     * @return AndroidNotification
     */
    public function setTimeToLive($time_to_live)
    {
        $this->time_to_live = $time_to_live;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getDelayWhileIdle()
    {
        return $this->delay_while_idle;
    }

    /**
     * @param boolean $delay_while_idle
     * @return AndroidNotification
     */
    public function setDelayWhileIdle($delay_while_idle)
    {
        $this->delay_while_idle = $delay_while_idle;

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
     * @return AndroidNotification
     */
    public function setContentAvailable($content_available)
    {
        $this->content_available = $content_available;

        return $this;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return AndroidNotification
     */
    public function setData($data)
    {
        $this->data = $data;

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
        $this->setTimeToLive(strtotime($delay) - time());

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