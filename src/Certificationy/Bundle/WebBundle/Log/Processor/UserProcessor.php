<?php

namespace Certificationy\Bundle\WebBundle\Log\Processor;

use Certificationy\Bundle\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserProcessor
{
    /**
     * @var \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param $record
     */
    public function postRecord($record)
    {
        try {
            $auth = $this->container->get('security.authorization_checker');
            $token = $this->container->get('security.token_storage');

            if ($auth->isGranted('IS_AUTHENTICATED_FULLY')) {

                /** @var User $user */
                $user = $token->getToken()->getUser();

                $record['extra']['user']['name'] = $user->getRealName();
                $record['extra']['user']['email'] = $user->getEmailCanonical();
                $record['extra']['user']['id'] = $user->getId();

                return $record;
            }
        } catch (\Exception $e) {}

        return $record;
    }
}
