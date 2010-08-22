<?php

require_once dirname(__FILE__) . '/bootstrap.php';

class StorymarketTest extends StorymarketTestCase {
    public function test_has_a_VERSION_property() {
        $v = Storymarket::VERSION;
        $this->assertTrue(isset($v));
    }
}

