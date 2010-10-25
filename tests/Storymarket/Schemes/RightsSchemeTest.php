<?php

require_once dirname(dirname(dirname(__FILE__))) . '/bootstrap.php';

class Storymarket_Schemes_RightsSchemeTest extends StorymarketTestCase {
    public function test_exists() {
        $this->assertTrue(class_exists('Storymarket_Schemes_RightsScheme'));
    }

    public function test_is_a_LinkedResource() {
        $this->assertSubclassOf(
            'Storymarket_Schemes_RightsScheme',
            'Storymarket_Links_LinkedResource'
        );
    }
}

