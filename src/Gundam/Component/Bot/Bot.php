<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Gundam\Component\Bot;

use Gundam\Component\Github\Client;
use Gundam\Component\Github\Events;
use Gundam\Component\Github\Security;
use Gundam\Component\Bot\Reaction\LoggableReactionInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Stopwatch\Stopwatch;

abstract class Bot implements BotInterface
{
    /**
     * @var \Gundam\Component\Github\Client
     */
    protected $client;

    /**
     * @var \Gundam\Component\Github\Security
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
     * @var \Symfony\Component\Stopwatch\Stopwatch
     */
    protected $stopwatch;

    /**
     * @param Client   $client
     * @param Security $security
     */
    public function __construct(Client $client, Security $security)
    {
        $this->client = $client;
        $this->security = $security;
        $this->actionDispatcher = new EventDispatcher();
        $this->stopwatch = new Stopwatch();
        $this->stopwatch->start('bot');
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
        return array_key_exists($incoming, $this->getGithubEvents());
    }

    /**
     * @return Response
     */
    protected function createResponse($content = null)
    {
        $response = new Response();

        //In the future, we must be able to cache some call to save API request limit
        $response->headers->addCacheControlDirective('no-cache', true);
        $response->headers->addCacheControlDirective('max-age', 0);
        $response->headers->addCacheControlDirective('must-revalidate', true);
        $response->headers->addCacheControlDirective('no-store', true);

        if (null !== $content) {
            $response->setContent($content);
        }

        return $response;
    }

    /**
     * @param Request $request
     *
     * @return Response
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function handle(Request $request)
    {
        $this->stopwatch->start('bot');

        $data = $this->security->handleRequest($request);

        if ($data['event'] === Events::PING) {
            return $this->createResponse('PONG - '.$data['delivery_uuid']);
        }

        if (!$this->matchEvent($data['event']) && $data['event']) {

            if (null !== $this->logger) {
                $this->logger->debug(sprintf(
                    '%s accept following events [ %s ] given : %s',
                    get_class($this),
                    implode(', ', array_keys($this->getGithubEvents())),
                    $data['event']
                ));
            }

            throw new HttpException(Response::HTTP_ACCEPTED); //We accept the request, but we do nothing (202).
        }

        $this->doHandle($data['event'], $request, $data, $response = $this->createResponse());

        return $response;
    }

    /**
     * @param string   $eventName
     * @param Request  $request
     * @param array    $data
     * @param Response $response
     *
     * @return mixed
     */
    protected function doHandle($eventName, Request $request, array $data, Response $response)
    {
        return $this->{$this->getGithubEvents()[$eventName]}($request, $data, $response);
    }

    /**
     * @param EventSubscriberInterface $subscriber
     */
    public function registerActionSubscriber(EventSubscriberInterface $subscriber)
    {
        if ($subscriber instanceof LoggableReactionInterface) {
            $subscriber->setLogger($this->logger);
        }

        $this->actionDispatcher->addSubscriber($subscriber);
    }

    /**
     * @param object $listener
     * @param string $eventName
     * @param int    $priority
     */
    public function registerActionListener($listener, $eventName, $priority = 0)
    {
        if ($listener instanceof LoggableReactionInterface) {
            $listener->setLogger($this->logger);
        }

        $this->actionDispatcher->addListener(
            $eventName,
            [$listener, 'perform'],
            $priority
        );
    }
}
