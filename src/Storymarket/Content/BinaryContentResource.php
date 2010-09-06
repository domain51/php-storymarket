<?php

class Storymarket_Content_BinaryContentResource extends Storymarket_Base_Resource {
    public function uploadFile($file) {
        $this->manager->uploadFile($file);
    }
}

