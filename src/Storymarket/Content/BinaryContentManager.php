<?php

class Storymarket_Content_BinaryContentManager extends Storymarket_Content_ContentManager {
    public function uploadFile($resource, $file) {
        $url = $this->_buildUrl($resource->id, 'blob');
        $this->_handler->doUploadFile($url, $file);
    }
}

