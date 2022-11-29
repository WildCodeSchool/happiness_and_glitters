<?php

namespace App\EventListener;

use Spatie\Url\Url;
use Symfony\Bundle\SecurityBundle\Security\FirewallMap;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Symfony\Component\Security\Http\FirewallMapInterface;

#[AsEventListener(event: LogoutEvent::class, method: 'onLogout')]
final class LogoutListener
{
    private FirewallMap $firewallMap;

    public function __construct(FirewallMapInterface $firewallMap)
    {
        if ($firewallMap instanceof FirewallMap) {
            $this->firewallMap = $firewallMap;
        }
    }

    public function onLogout(LogoutEvent $event): void
    {
        $firewall = $this->firewallMap->getFirewallConfig($event->getRequest());

        if ('admin' === $firewall->getName()) {
            $request = $event->getRequest();
            $response = $event->getResponse();
            $requestUrl = Url::fromString($request->getUri());
            $responseRedirectUrl = Url::fromString($response->headers->get("Location"))
                                    ->withQueryParameters($requestUrl->getAllQueryParameters());
            $response->headers->set("Location", $responseRedirectUrl);
        }
    }
}
