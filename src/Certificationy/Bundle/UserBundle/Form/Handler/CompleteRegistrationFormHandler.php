<?php

namespace Certificationy\Bundle\UserBundle\Form\Handler;

use Certificationy\Bundle\CertyBundle\Form\Handler\Handler;
use Certificationy\Bundle\UserBundle\Entity\User;
use FOS\UserBundle\Doctrine\UserManager;

class CompleteRegistrationFormHandler extends Handler
{
    /**
     * @var UserManager
     */
    protected $userManager;

    /**
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    public function process(User $user)
    {
        $this->createForm($user);
        return $this->handle('POST');
    }

    /**
     * @param $user
     *
     * @return bool
     */
    public function onSuccess($user)
    {
        $this->userManager->updateUser($user);

        return true;
    }
} 