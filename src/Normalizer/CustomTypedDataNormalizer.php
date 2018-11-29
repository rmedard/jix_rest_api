<?php
/**
 * Created by PhpStorm.
 * User: medard
 * Date: 25/03/2017
 * Time: 17:06
 */

namespace Drupal\jir_rest_api\Normalizer;

use Drupal\serialization\Normalizer\NormalizerBase;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;

class CustomTypedDataNormalizer extends NormalizerBase {

    protected $supportedInterfaceOrClass = 'Drupal\Core\TypedData\TypedDataInterface';

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
        $value = $object->getValue();
//        kint($value);
//        die();
        if (is_array($value) and is_array($value[0])){
            if (isset($value[0]->value)) {
                $value = $value[0]->value;
            }
        }
        return $value;
    }
}