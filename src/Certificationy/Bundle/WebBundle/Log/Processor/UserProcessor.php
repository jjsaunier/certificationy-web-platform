<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\WebBundle\Log\Processor;

use Certificationy\Bundle\UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;

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
        $auth = $this->container->get('security.authorization_checker');
        $token = $this->container->get('security.token_storage');

        try {
            if ($auth->isGranted('IS_AUTHENTICATED_FULLY')) {

                /** @var User $user */
                $user = $token->getToken()->getUser();

                $record['extra']['user']['name'] = $user->getRealName();
                $record['extra']['user']['email'] = $user->getEmailCanonical();
                $record['extra']['user']['id'] = $user->getId();

                return $record;
            }
        } catch (AuthenticationCredentialsNotFoundException $e) {}

        return $record;
    }
}
