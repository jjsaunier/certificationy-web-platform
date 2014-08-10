<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\GithubBundle\Bot\Certificationy\Reaction;

use Certificationy\Bundle\GithubBundle\Bot\Certificationy\Action\CheckAction;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser;

class CheckUniquenessReaction
{
    use CheckReactionTrait;

    /**
     * @param CheckAction $action
     */
    public function perform(CheckAction $action)
    {
        $files = $this->getFiles($action->getBasePath());
        $parser = new Parser();

        foreach ($files as $file) {

            try {
                $data = $parser->parse(file_get_contents($file->getRealPath()));
            } catch (ParseException $e) {
                continue;
            }
        }
    }
}
