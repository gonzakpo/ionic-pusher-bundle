<?php

namespace Draw\IonicPusherBundle\Debug;

use Draw\IonicPusherBundle\Pusher\DataCollectorPusherDecorator;
use Draw\IonicPusherBundle\Pusher\Pusher;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class PusherDataCollector extends DataCollector implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @var DataCollectorPusherDecorator
     */
    private $pusherDecorator;

    public function __construct(DataCollectorPusherDecorator $pusherDecorator)
    {
        $this->pusherDecorator = $pusherDecorator;
        $this->data['auth_token'] = $pusherDecorator->getAuthToken();
    }

    /**
     * Collects data for the given Request and Response.
     *
     * @param Request $request A Request instance
     * @param Response $response A Response instance
     * @param \Exception $exception An Exception instance
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $this->data['requests'] = $this->pusherDecorator->getRequests();
    }

    public function getRequests()
    {
        return $this->data['requests'];
    }

    public function getNotificationStatus($uuid)
    {
        if(is_null($this->pusherDecorator)) {
            $this->pusherDecorator = new Pusher($this->data['auth_token']);
        }
        return $this->pusherDecorator->getNotificationStatus($uuid);
    }

    /**
     * Returns the name of the collector.
     *
     * @return string The collector name
     */
    public function getName()
    {
        return 'draw.ionic.pusher.collector';
    }

}