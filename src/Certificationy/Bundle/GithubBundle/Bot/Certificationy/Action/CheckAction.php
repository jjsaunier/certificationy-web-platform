<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\GithubBundle\Bot\Certificationy\Action;

use Gundam\Component\Bot\Action\GenericAction;
use Gundam\Component\Github\Client;

class CheckAction extends GenericAction
{
    /**
     * @var Array
     */
    protected $errors;

    /**
     * @var string
     */
    protected $basePath;

    /**
     * @var Array
     */
    protected $skip;

    /**
     * @param Client $client
     * @param array  $data
     * @param string $basePath
     */
    public function __construct(Client $client, array $data, $basePath)
    {
        parent::__construct($client, $data);

        $this->errors = [
            'total' => 0,
            'structure' => [],
            'integrity' => [],
            'parser' => []
        ];

        $this->basePath = $basePath;

        $this->skip = [
            'file' => [],
            'category' => [],
            'question' => [],
            'answer' => []
        ];
    }

    /**
     * @param string $type
     * @param string $message
     * @param array  $context
     */
    public function addError($type, $message, array $context = [])
    {
        if (!isset($this->errors[$type])) {
            $this->errors[$type] = [];
        }

        $this->errors[$type][] = [
            'message' => $message,
            'context' => $context
        ];

        $this->errors['total']++;
    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @return Array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @param $type
     * @param $identifier
     */
    public function addSkip($type, $identifier)
    {
        $this->skip[$type][] = $identifier;
    }

    /**
     * @param $type
     *
     * @return mixed
     */
    public function getSkip($type)
    {
        return $this->skip[$type];
    }
}
