<?php

namespace Acme;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GoogleListener implements EventSubscriberInterface
{
	public function onResponse(\Symfony\Component\HttpKernel\Event\FilterResponseEvent $event)
	{
		$response = $event->getResponse();

		if($response->isRedirection()
			|| ($response->headers->has('Content-Type') && strpos($response->headers->get('Content-Type'), 'html') == false)
			|| $event->getRequest()->getRequestFormat() !== 'html'
			|| !$event->isMasterRequest()
		) {
			return;
		}

		$response->setContent($response->getContent() . 'GOOGLE ANALYTICS CODE');
	}

	public static function getSubscribedEvents()
	{
		return ['kernel.response' => 'onResponse'];
	}
}