<?php

class Storymarket_Links_Link {
    public function __construct($rel, $href, $allowedMethods) {
        $this->rel = $rel;
        $this->href = $href;
        $this->allowedMethods = $allowedMethods;
    }

    public function __toString() {
        return $this->href;
    }
}

