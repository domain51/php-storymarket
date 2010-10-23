<?php

require_once dirname(dirname(dirname(__FILE__))) . '/bootstrap.php';

class Storymarket_Categories_CategoryTest extends StorymarketTestCase {
    public function test_is_a_LinkedResource() {
        $reflection = new ReflectionClass('Storymarket_Categories_Category');
        $this->assertTrue($reflection->isSubclassOf('Storymarket_Links_LinkedResource'));
    }
}

