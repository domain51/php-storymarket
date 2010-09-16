<?php

require_once dirname(__FILE__) . '/bootstrap.php';

class StorymarketTest extends StorymarketTestCase {
    public function test_has_a_VERSION_property() {
        $v = Storymarket::VERSION;
        $this->assertTrue(isset($v));
    }

    public function testHasVideoProperty() {
        $v = new Storymarket('api_key');
        $this->assertTrue(isset($v->video));
        $this->assertType('Storymarket_Content_VideoManager', $v->video);
    }

    public function testHasTextProperty() {
        $v = new Storymarket('api_key');
        $this->assertTrue(isset($v->text));
        $this->assertType('Storymarket_Content_TextManager', $v->text);
    }

}

