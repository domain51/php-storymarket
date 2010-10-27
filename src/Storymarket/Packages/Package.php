<?php

class Storymarket_Packages_Package extends Storymarket_Content_Resource {

    private function _buildMap() {
        static $cached = null;
        if (empty($cached)) {
            $cached = array(
                'audioItems' => array(
                    'manager' => $this->manager->_api->audio,
                    'class' => 'Storymarket_Content_Audio',
                ),
                'audio_items' => 'audioItems',

                'dataItems' => array(
                    'manager' => $this->manager->_api->data,
                    'class' => 'Storymarket_Content_Data',
                ),
                'data_items' => 'dataItems',

                'photoItems' => array(
                    'manager' => $this->manager->_api->photos,
                    'class' => 'Storymarket_Content_Photo',
                ),
                'photo_items' => 'photoItems',

                'textItems' => array(
                    'manager' => $this->manager->_api->text,
                    'class' => 'Storymarket_Content_Text',
                ),
                'text_items' => 'textItems',

                'videoItems' => array(
                    'manager' => $this->manager->_api->video,
                    'class' => 'Storymarket_Content_Video',
                ),
                'video_items' => 'videoItems',

            );
        }
        return $cached;
    }

    private function _canHandleKey($key) {
        $map = $this->_buildMap();
        return isset($map[$key]);
    }

    private function _buildValue($key, $data) {
        $map = $this->_buildMap($key);
        if (is_string($map[$key])) {
            $key = $map[$key];
        }
        $manager = $map[$key]['manager'];
        $class = $map[$key]['class'];
        $ret = array();
        foreach ($data as $item) {
            $ret[] = new $class($manager, $item);
        }
        return $ret;
    }


    public function __get($key) {
        $data = parent::__get($key);
        if (empty($data)) {
            return $data;
        }

        if ($this->_canHandleKey($key)) {
            return $this->_buildValue($key, $data);
        }

        return $data;
    }

    public function __isset($key) {
        return $this->_canHandleKey($key) ? true : parent::__isset($key);
    }
}

