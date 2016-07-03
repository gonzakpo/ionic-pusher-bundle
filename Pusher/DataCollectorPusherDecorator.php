<?php

namespace Draw\IonicPusherBundle\Pusher;

use \acurrieclark\IonicPhpPusher\Pusher;

class DataCollectorPusherDecorator extends Pusher
{
    /**
     * @var Pusher
     */
    private $decoratedPusher;

    private $requests = [];

    public function __construct(Pusher $decoratedPusher)
    {
        $this->decoratedPusher = $decoratedPusher;
    }

    public function getAuthToken()
    {
        return $this->decoratedPusher->getAuthToken();
    }

    public function sendToTokens($tokens, $profile, $notification, $scheduled = null) {

        $request = get_defined_vars();;
        $request['result'] = $this->decoratedPusher->sendToTokens($tokens, $profile, $notification, $scheduled);
        $this->requests[] = $request;
        return $request['result'];
    }

    public function testApiAccess()
    {
        return $this->decoratedPusher->testApiAccess();
    }

    public function getRequests()
    {
        return $this->requests;
    }
}