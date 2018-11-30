<?php
/**
 * Created by PhpStorm.
 * User: medard
 * Date: 26/03/2017
 * Time: 15:32
 */

namespace Drupal\jir_rest_api\Normalizer;


use Drupal\filter\Render\FilteredMarkup;
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

        $value = $object->getValue();
        try {
            if (!($value instanceof FilteredMarkup) and isset($value[0])) {
                if (isset($value[0]['value'])) {
                    $value = $value[0]['value'];
                }
            } else {
                \Drupal::logger('jix_rest_api')->debug("FilteredMarkup...");
            }
            return $value;
        } catch (\Exception $ex) {
            \Drupal::logger('jix_rest_api')->debug("Byagagaye: " . $ex);
        }
        return "";
    }
}