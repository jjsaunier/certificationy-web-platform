<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\GithubBundle\Bot\Common\Action;

use Certificationy\Bundle\GithubBundle\Api\Client;

class SwitchCommitStatusAction extends GenericAction
{
    /**
     * @var string
     */
    protected $message;

    /**
     * @param Client $client
     * @param array  $data
     * @param string $message
     */
    public function __construct(Client $client, array $data, $message)
    {
        parent::__construct($client, $data);

        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
