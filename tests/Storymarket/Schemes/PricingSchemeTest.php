<?php

require_once dirname(dirname(dirname(__FILE__))) . '/bootstrap.php';

class Storymarket_Schemes_PricingSchemeTest extends StorymarketTestCase {
    public function test_exists() {
        $this->assertTrue(class_exists('Storymarket_Schemes_PricingScheme'));
    }

    public function test_is_a_LinkedResource() {
        $this->assertSubclassOf(
            'Storymarket_Schemes_PricingScheme',
            'Storymarket_Links_LinkedResource'
        );
    }
}

