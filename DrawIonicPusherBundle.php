<?php

namespace Draw\IonicPusherBundle;

use Draw\IonicPusherBundle\DependencyInjection\DrawIonicPusherExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DrawIonicPusherBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new DrawIonicPusherExtension();
    }
}
