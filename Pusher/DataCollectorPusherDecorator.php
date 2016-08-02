<?php

namespace Draw\IonicPusherBundle\Pusher;

class DataCollectorPusherDecorator extends Pusher
{
    /**
     * @var Pusher
     */
    private $decoratedPusher;

    private $requests = [];

    public function __construct(Pusher $decoratedPusher)
    {
        parent::__construct($decoratedPusher->getAuthToken(), $decoratedPusher->getDefaultProfile());
        $this->decoratedPusher = $decoratedPusher;
    }

    public function getAuthToken()
    {
        return $this->decoratedPusher->getAuthToken();
    }

    public function sendPushNotification(PushNotification $pushNotification) {

        $request['pushNotification'] = $pushNotification;
        $request['result'] = $this->decoratedPusher->sendPushNotification($pushNotification);
        $this->requests[] = $request;
        return $request['result'];
    }

    public function testApiAccess()
    {
        return $this->decoratedPusher->testApiAccess();
    }

    public function getNotificationStatus($uuid)
    {
        return $this->decoratedPusher->getNotificationStatus($uuid);
    }

    public function getRequests()
    {
        return $this->requests;
    }
}