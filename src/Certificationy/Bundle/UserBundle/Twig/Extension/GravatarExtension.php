<?php
/**
 * This file is part of the Certificationy Web Platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\UserBundle\Twig\Extension;

use Certificationy\Bundle\UserBundle\Entity\User;
use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Component\Security\Core\SecurityContext;

class GravatarExtension extends \Twig_Extension
{
    /**
     * @var \Symfony\Component\Security\Core\SecurityContext
     */
    protected $securityContext;

    /**
     * @var \FOS\UserBundle\Doctrine\UserManager
     */
    protected $userManager;

    /**
     * @param SecurityContext $securityContext
     * @param UserManager     $userManager
     */
    public function __construct(
        SecurityContext $securityContext,
        UserManager $userManager
    ) {
        $this->securityContext = $securityContext;
        $this->userManager = $userManager;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            'gravatar' => new \Twig_SimpleFunction('gravatar', [$this, 'getGravatarImage'])
        ];
    }

    /**
     * @param null|User|string $user
     *                               string: Email or Username
     *                               User: User instance
     *                               null: CurrentUser if auth else placeholder
     *
     * @param int $size
     *
     * @return string
     */
    public function getGravatarImage($user = null, $size = 80)
    {
        $defaultImage = 'www.locastic.com/no-gravatar-image.jpg';

        if (null === $user) {
            if (false === $this->securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
                return $defaultImage;
            }

            $user = $this->securityContext->getToken()->getUser();
        } else {
            if (!$user instanceof User) {
                $user = $this->userManager->findUserByUsernameOrEmail($user);
            }
        }

        if (null !== $user->getGithubID()) {
            return $this->renderGithubGravatar($user, $size);
        }

        return $this->renderDefaultGravatar($user, $size);
    }

    /**
     * @param User    $user
     * @param integer $size
     *
     * @return string
     */
    protected function renderGithubGravatar(User $user, $size)
    {
        return $user->getAvatarUrl().$user->getGravatarId().'&s='.$size;
    }

    /**
     * @param User    $user
     * @param integer $size
     *
     * @return string
     */
    protected function renderDefaultGravatar(User $user, $size)
    {
        return sprintf(
            'http://www.gravatar.com/avatar/%s&s=%s',
            md5(strtolower(trim($user->getEmailCanonical()))),
            $size
        );
    }

    public function getName()
    {
        return 'gravatar';
    }
}
