<?php
/**
 * Created by PhpStorm.
 * User: medard
 * Date: 26/03/2017
 * Time: 15:32
 */

namespace Drupal\jir_rest_api\Normalizer;


use Drupal\serialization\Normalizer\NormalizerBase;

class TypedDataNormalizer extends NormalizerBase
{

    /**
     * The interface or class that this Normalizer supports.
     * @var string
     */
    protected $supportedInterfaceOrClass = 'Drupal\Core\TypedData\TypedDataInterface';

    public function normalize($object, $format = NULL, array $context = array())
    {
//        kint($object);
//        die();
        $value = $object->getValue();
        if (isset($value[0]) && isset($value[0]['value'])) {
            $value = $value[0]['value'];
        }
        return $value;
    }
}