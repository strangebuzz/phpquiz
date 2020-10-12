<?php declare(strict_types=1);

namespace App\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\KernelInterface;

class EnvToRequestSubscriber implements EventSubscriberInterface
{
    protected RequestStack $requestStack;
    protected KernelInterface $kernel;

    public function __construct(RequestStack $requestStack, KernelInterface $kernel)
    {
        $this->requestStack = $requestStack;
        $this->kernel = $kernel;
    }

    /**
     * @see php bin/console debug:event-dispatcher kernel.request
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 10] // must be afer FirewallListeners
        ];
    }

    /**
     * Set the env in the request attributes so it be accessed by the security
     * component.
     *
     * @see security.yml
     */
    public function onKernelRequest(RequestEvent $event): Request
    {
        $request = $event->getRequest();
        if ($request instanceof Request) {
            $request->attributes->set('env', $this->kernel->getEnvironment());
        }

        return $request;
    }
}
