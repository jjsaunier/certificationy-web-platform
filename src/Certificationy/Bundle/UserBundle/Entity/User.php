<?php
/**
 * This file is part of the Certificationy Web Platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 *
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="email", column=@ORM\Column(type="string", name="email", length=255, unique=false, nullable=true)),
 *      @ORM\AttributeOverride(name="emailCanonical", column=@ORM\Column(type="string", name="email_canonical", length=255, unique=false, nullable=true))
 * })
 **/
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="github_id", type="string", nullable=true)
     */
    protected $githubID;

    /**
     * @var string
     * @ORM\Column(name="github_access_token", type="string", length=255, nullable=true)
     */
    protected $githubAccessToken;

    /**
     * @var string
     * @ORM\Column(name="real_name", type="string", length=255, nullable=true)
     */
    protected $realName;

    /**
     * @var string
     * @ORM\Column(name="avatar_url", type="string", length=255, nullable=true)
     */
    protected $avatarUrl;

    /**
     * @var string
     * @ORM\Column(name="gravatar_id", type="string", length=255, nullable=true)
     */
    protected $gravatarId;

    /**
     * @param string $githubID
     */
    public function setGithubID($githubID)
    {
        $this->githubID = $githubID;
    }

    /**
     * @return string
     */
    public function getGithubID()
    {
        return $this->githubID;
    }

    /**
     * @param string $githubAccessToken
     */
    public function setGithubAccessToken($githubAccessToken)
    {
        $this->githubAccessToken = $githubAccessToken;
    }

    /**
     * @return string
     */
    public function getGithubAccessToken()
    {
        return $this->githubAccessToken;
    }

    /**
     * @param string $avatarUrl
     */
    public function setAvatarUrl($avatarUrl)
    {
        $this->avatarUrl = $avatarUrl;
    }

    /**
     * @return string
     */
    public function getAvatarUrl()
    {
        return $this->avatarUrl;
    }

    /**
     * @param string $gravatarId
     */
    public function setGravatarId($gravatarId)
    {
        $this->gravatarId = $gravatarId;
    }

    /**
     * @return string
     */
    public function getGravatarId()
    {
        return $this->gravatarId;
    }

    /**
     * @param string $realName
     */
    public function setRealName($realName)
    {
        $this->realName = $realName;
    }

    /**
     * @return string
     */
    public function getRealName()
    {
        return $this->realName;
    }

    /**
     * @return bool
     */
    public function isIncomplete()
    {
        return null === $this->getRealName() || null === $this->getEmail();
    }
}
