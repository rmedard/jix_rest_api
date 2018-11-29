<?php
/**
 * Created by PhpStorm.
 * User: medard
 * Date: 25/03/2017
 * Time: 17:06
 */

namespace Drupal\jir_rest_api\Normalizer;


use Drupal;
use Drupal\serialization\Normalizer\NormalizerBase;
use phpDocumentor\Reflection\Types\Scalar;

class CustomTypedDataNormalizer extends NormalizerBase {

    protected $supportedInterfaceOrClass = 'Drupal\Core\TypedData\TypedDataInterface';

    /**
     * Normalizes an object into a set of arrays/scalars.
     *
     * @param object $object object to normalize
     * @param string $format format the normalization result will be encoded as
     * @param array $context Context options for the normalizer
     *
     * @return array|scalar
     */
    public function normalize($object, $format = null, array $context = array()){
        $value = $object->getValue();
        if (isset($value[0]) && isset($value[0]['value'])){
            $value = $value[0]['value'];
        }
        return $value;
    }
}