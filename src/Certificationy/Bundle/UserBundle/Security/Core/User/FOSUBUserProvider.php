<?php
/**
 * This file is part of the Certificationy Web Platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\UserBundle\Security\Core\User;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\Security\Core\User\UserInterface;

class FOSUBUserProvider extends BaseClass
{
    /**
     * @param UserInterface         $user
     * @param UserResponseInterface $response
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $property = $this->getProperty($response);
        $username = $response->getUsername();

        //on connect - get the access token and the user ID
        $service = $response->getResourceOwner()->getName();

        $setter = 'set'.ucfirst($service);
        $setterId = $setter.'Id';
        $setterToken = $setter.'AccessToken';

        //we "disconnect" previously connected users
        if (null !== $previousUser = $this->userManager->findUserBy([$property => $username])) {
            $previousUser->{$setterId}(null);
            $previousUser->{$setterToken}(null);
            $this->userManager->updateUser($previousUser);
        }

        //we connect current user
        $user->{$setterId}($username);
        $user->{$setterToken}($response->getAccessToken());

        $this->userManager->updateUser($user);
    }

    /**
     * @param UserResponseInterface $response
     *
     * @return \FOS\UserBundle\Model\UserInterface|UserInterface
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $data = $response->getResponse();
        $username = $data['login'];

        $user = $this->userManager->findUserByUsername($username);

        //when the user is registrating
        if (null === $user) {
            $service = $response->getResourceOwner()->getName();
            $setter = 'set'.ucfirst($service);
            $setterId = $setter.'Id';
            $setterToken = $setter.'AccessToken';

            // create new user here
            $user = $this->userManager->createUser();
            $user->{$setterId}($data['id']);
            $user->{$setterToken}($response->getAccessToken());

            //I have set all requested data with the user's username modify here with relevant data
            $user->setUsername($username);
            $user->setEmail($data['email']);
            $user->setPlainPassword($data['id']);
            $user->setAvatarUrl($data['avatar_url']);
            $user->setGravatarId($data['gravatar_id']);
            $user->setRealName($data['name']);
            $user->setEnabled(true);
            $this->userManager->updateUser($user);

            return $user;
        }

        //if user exists - go with the HWIOAuth way
        $user = parent::loadUserByOAuthUserResponse($response);

        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';

        //update access token
        $user->{$setter}($response->getAccessToken());

        return $user;
    }
}
