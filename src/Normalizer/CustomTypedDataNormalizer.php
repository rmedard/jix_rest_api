<?php
/**
 * Created by PhpStorm.
 * User: medard
 * Date: 25/03/2017
 * Time: 17:06
 */

namespace Drupal\jir_rest_api\Normalizer;

use Drupal\Core\Field\FieldItemInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CustomTypedDataNormalizer implements NormalizerInterface {

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
        \Drupal::logger('jix_rest_api')->debug('normalizer called...');
        if ($object instanceof NodeInterface) {
            $object = $object->getValue();
        }
        return $object;

//        $value = $object->getValue();
////        kint($value);
////        die();
//        if (is_array($value) and isset($value[0]->{'value'})){
////            if (isset($value[0]->value)) {
//                $value = $value[0]->{'value'};
////            }
//        }
//        return $value;
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