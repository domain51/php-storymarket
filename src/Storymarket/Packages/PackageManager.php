<?php

class Storymarket_Packages_PackageManager extends Storymarket_Content_ContentManager {
    public $_url_bit = 'package';

    public function __construct($api, $handler=null, $url_bit=null) {
        parent::__construct($api, $handler, $url_bit);
        array_push($this->_flattenFields,
            'audio_items',
            'data_items',
            'photo_items',
            'text_items',
            'video_items'
        );
    }

    public function toArray($resource) {
        $array = parent::toArray($resource);

        foreach ($this->_flattenFields as $field) {
            if (substr($field, -6) !== '_items') {
                continue;
            }

            $relatedType = substr($field, 0, -6);
            $key = "{$relatedType}_items";
            if (empty($array[$key])) {
                continue;
            }
            $relatedArray = array();

            foreach ($array[$key] as $related) {
                $related = "/content/{$relatedType}/{$related->id}/";
                $relatedArray[] = $related;
            }
            $array[$key] = $relatedArray;
        }

        return $array;

    }
}

