<?php
namespace AppBundle\Service;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

class AddLinkHeaderListener
{
    /**
     * Set the Access-Control-Allow-Origin for partners
     *
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $event->getResponse()->headers->set('Access-Control-Allow-Origin', 'http://elpida.local');
    }
}