<?php
/**
 * This file is part of the PhpStorm.
 * (c) johann (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Component\Certy\Model\Serializer;

use Certificationy\Component\Certy\Model\ModelCollection;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\VisitorInterface;

class ModelCollectionHandler implements SubscribingHandlerInterface
{
    /**
     * @return array
     */
    public static function getSubscribingMethods()
    {
        $methods = array();
        $formats = array('json', 'xml', 'yml');
        $collectionTypes = array(
            'ModelCollection',
            'Certificationy\Component\Certy\Model\ModelCollection'
        );

        foreach ($collectionTypes as $type) {
            foreach ($formats as $format) {
                $methods[] = array(
                    'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                    'type' => $type,
                    'format' => $format,
                    'method' => 'serializeCollection',
                );

                $methods[] = array(
                    'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                    'type' => $type,
                    'format' => $format,
                    'method' => 'deserializeCollection',
                );
            }
        }

        return $methods;
    }

    /**
     * @param VisitorInterface $visitor
     * @param ModelCollection  $collection
     * @param array            $type
     * @param Context          $context
     *
     * @return mixed
     */
    public function serializeCollection(VisitorInterface $visitor, ModelCollection $collection, array $type, Context $context)
    {
        $type['name'] = 'array';

        return $visitor->visitArray($collection->toArray(), $type, $context);
    }

    /**
     * @param VisitorInterface $visitor
     * @param                  $data
     * @param array            $type
     * @param Context          $context
     *
     * @return ModelCollection
     */
    public function deserializeCollection(VisitorInterface $visitor, $data, array $type, Context $context)
    {
        $type['name'] = 'array';

        return new ModelCollection($visitor->visitArray($data, $type, $context));
    }
}
