<?php

namespace Draw\IonicPusherBundle\Pusher;

class Pusher extends \acurrieclark\IonicPhpPusher\Pusher
{
    public function getNotificationStatus($uuid)
    {
        return json_decode($this->sendRequest(
            'GET',
            'https://api.ionic.io/push/notifications/' . $uuid . '/messages',
            $this->getHeaders()
        )->getBody()->getContents(), true);
    }
}