<?php

namespace App\EventListener;

use Spatie\Url\Url;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Http\Event\LogoutEvent;

#[AsEventListener(event: LogoutEvent::class, method: 'onLogout')]
class LogoutListener
{
    public function onLogout(LogoutEvent $event): void
    {
        $request = $event->getRequest();
        $response = $event->getResponse();
        $failed = $request->get('access_denied');
        if ($failed === "1") {
            $url = Url::fromString($response->headers->get("Location"));
            $url = $url->withQueryParameter('access_denied', $failed);
            $response->headers->set("location", $url);
        }
    }
}
