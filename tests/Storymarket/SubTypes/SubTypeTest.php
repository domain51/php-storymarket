<?php

require_once dirname(dirname(dirname(__FILE__))) . '/bootstrap.php';

class Storymarket_SubTypes_SubTypeTest extends StorymarketTestCase {
    public function test_is_a_LinkedResource() {
        $reflection = new ReflectionClass('Storymarket_SubTypes_SubType');
        $this->assertTrue($reflection->isSubclassOf('Storymarket_Links_LinkedResource'));
    }
}

