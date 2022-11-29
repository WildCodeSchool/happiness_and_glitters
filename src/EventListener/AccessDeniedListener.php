<?php

namespace App\EventListener;

use Symfony\Bundle\SecurityBundle\Security\FirewallMap;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\FirewallMapInterface;

#[AsEventListener(event: "kernel.exception")]
final class AccessDeniedListener
{
    private FirewallMap $firewallMap;

    public function __construct(FirewallMapInterface $firewallMap, private RouterInterface $router)
    {
        if ($firewallMap instanceof FirewallMap) {
            $this->firewallMap = $firewallMap;
        }
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $firewall = $this->firewallMap->getFirewallConfig($event->getRequest());

        if ('admin' === $firewall->getName() && $exception instanceof AccessDeniedHttpException) {
            $response = new RedirectResponse($this->router->generate('app_admin_logout', [
                'access_denied' => true
            ]));
            $event->setResponse($response);
        }
    }
}
