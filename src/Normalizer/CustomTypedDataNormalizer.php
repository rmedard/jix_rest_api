<?php
/**
 * Created by PhpStorm.
 * User: medard
 * Date: 25/03/2017
 * Time: 17:06
 */

namespace Drupal\jir_rest_api\Normalizer;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\hal\Normalizer\ContentEntityNormalizer;
use Drupal\node\NodeInterface;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;

class CustomTypedDataNormalizer extends ContentEntityNormalizer {

    /**
     * Normalizes an object into a set of arrays/scalars.
     *
     * @param mixed $object Object to normalize
     * @param string $format Format the normalization result will be encoded as
     * @param array $context Context options for the normalizer
     *
     * @return array|string|int|float|bool
     *
     * @throws InvalidArgumentException   Occurs when the object given is not an attempted type for the normalizer
     * @throws CircularReferenceException Occurs when the normalizer detects a circular reference when no circular
     *                                    reference handler can fix it
     * @throws LogicException             Occurs when the normalizer is not called in an expected context
     */
    public function normalize($object, $format = null, array $context = array())
    {

        $attributes = parent::normalize($object);
        $changed_timestamp = $object->getChangedTime();
        $created_timestamp = $object->getCreatedTime();

        $changed_date = DrupalDateTime::createFromTimestamp($changed_timestamp);
        $created_date = DrupalDateTime::createFromTimestamp($created_timestamp);

        $attributes['changed_iso8601'] = $changed_date->format('d-m-Y H:i:s');
        $attributes['created_iso8601'] = $created_date->format('d-m-Y H:i:s');
        $attributes['link'] = $object->toUrl()->toString();
        ksort($attributes);

        \Drupal::logger('jix_rest_api')->debug('normalizer called...');
        return $attributes;
    }


    /**
     * Checks whether the given class is supported for normalization by this normalizer.
     *
     * @param mixed $data Data to normalize
     * @param string $format The format being (de-)serialized from or into
     *
     * @return bool
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof NodeInterface;
    }
}