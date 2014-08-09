<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\GithubBundle\Api;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Security
{
    /**
     * @var string
     */
    protected $secret;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Request $request
     */
    public function handleRequest(Request $request)
    {
        $content = $request->getContent();

        $identityCheck = explode('=', $request->headers->get('X-Hub-Signature'));

        if ($identityCheck[1] !== hash_hmac($identityCheck[0], $content, $this->secret)) {

            if (null !== $this->logger) {
                $this->logger->info('Github API wrong signature', array(
                    'request' => $request
                ));
            }

            throw new HttpException(Response::HTTP_FORBIDDEN);
        }

        if (null !== $this->logger) {
            $this->logger->info(
                sprintf('Github API called with event %s', $request->headers->get('X-GitHub-Event')),
                array('request' => $request)
            );
        }

        return array(
            'content' => json_decode($content, true),
            'event' => $request->headers->get('X-GitHub-Event'),
            'delivery_uuid' => $request->headers->get('X-GitHub-Delivery'),
            'debug' => (bool) $request->query->get('debug', false)
        );
    }

    /**
     * @param string $secret
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
    }
}
