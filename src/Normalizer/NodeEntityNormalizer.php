<?php
/**
 * Created by PhpStorm.
 * User: medard
 * Date: 26/03/2017
 * Time: 15:32
 */

namespace Drupal\jir_rest_api\Normalizer;


use Drupal;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Entity\EntityMalformedException;
use Drupal\node\NodeInterface;
use Drupal\serialization\Normalizer\ContentEntityNormalizer;

class NodeEntityNormalizer extends ContentEntityNormalizer {

    protected $supportedInterfaceOrClass = 'Drupal\node\NodeInterface';

    public function normalize($object, $format = NULL, array $context = array()){

        if ($object instanceof NodeInterface) {
            $attributes = parent::normalize($object, $format, $context);
            $changed_timestamp = $object->getChangedTime();
            $created_timestamp = $object->getCreatedTime();

            $changed_date = DrupalDateTime::createFromTimestamp($changed_timestamp);
            $created_date = DrupalDateTime::createFromTimestamp($created_timestamp);

            $attributes['changed_iso8601'] = $changed_date->format('d-m-Y H:i:s');
            $attributes['created_iso8601'] = $created_date->format('d-m-Y H:i:s');
            try {
                $attributes['link'] = $object->toUrl()->toString();
            } catch (EntityMalformedException $e) {
                Drupal::logger('jix_rest_api')
                    ->error(t('Entity URL creation failed @error', array('@error', $e)));
            }
            ksort($attributes);
            return $attributes;
        }
    }

}