<?php

require_once dirname(dirname(dirname(__FILE__))) . '/bootstrap.php';

class Storymarket_Orgs_OrgTest extends StorymarketTestCase {
    public function test_is_a_LinkedResource() {
        $reflection = new ReflectionClass('Storymarket_Orgs_Org');
        $this->assertTrue($reflection->isSubclassOf('Storymarket_Links_LinkedResource'));
    }
}

