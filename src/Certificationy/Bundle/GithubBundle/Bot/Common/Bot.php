<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\GithubBundle\Bot\Common;

use Certificationy\Bundle\GithubBundle\Api\Client;
use Certificationy\Bundle\GithubBundle\Api\Security;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class Bot implements BotInterface
{
    /**
     * @var \Certificationy\Bundle\GithubBundle\Api\Client
     */
    protected $client;

    /**
     * @var \Certificationy\Bundle\GithubBundle\Api\Security
     */
    protected $security;

    /**
     * @var \Symfony\Component\EventDispatcher\EventDispatcher
     */
    protected $actionDispatcher;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param Request  $request
     * @param array    $data
     * @param Response $response
     *
     * @return Response
     */
    abstract protected function doHandle(Request $request, array $data, Response $response);

    /**
     * @param Client   $client
     * @param Security $security
     */
    public function __construct(Client $client, Security $security)
    {
        $this->client = $client;
        $this->security = $security;
        $this->actionDispatcher = new EventDispatcher();
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }

    /**
     * @param $incoming
     *
     * @return bool
     */
    public function matchEvent($incoming)
    {
        return in_array($incoming, $this->getGithubEvents());
    }

    /**
     * @return Response
     */
    protected function createResponse()
    {
        $response = new Response();

        $response->headers->addCacheControlDirective('no-cache', true);
        $response->headers->addCacheControlDirective('max-age', 0);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        $response->headers->addCacheControlDirective('no-store', true);

        return $response;
    }

    /**
     * @param Request $request
     */
    public function handle(Request $request)
    {
        $data = $this->security->handleRequest($request);

        if (!$this->matchEvent($data['event'])) {
            throw new HttpException(Response::HTTP_NOT_FOUND);
        }

        return $this->doHandle($request, $data, $this->createResponse());
    }

    /**
     * @param EventSubscriberInterface $subscriber
     */
    public function registerActionSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->actionDispatcher->addSubscriber($subscriber);
    }

    /**
     * @param object $listener
     * @param string $eventName
     * @param string $method
     * @param int    $priority
     */
    public function registerActionListener($listener, $eventName, $priority = 0)
    {
        $this->actionDispatcher->addListener(
            $eventName,
            array($listener, 'perform'),
            $priority
        );
    }
}
