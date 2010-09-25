<?php

require_once dirname(dirname(dirname(__FILE__))) . '/bootstrap.php';

class Storymarket_Links_LinkTest extends StorymarketTestCase {
    public function setUp() {
        $this->randomRel = 'rel-' . rand(100, 200);
        $this->randomHref = 'href-' . rand(100, 200);
        $this->randomAllowedMethods = 'allowed-methods-' . rand(100, 200);

        $this->link = new Storymarket_Links_Link($this->randomRel, $this->randomHref, $this->randomAllowedMethods);
    }

    public function test_provides_rel_property() {
        $this->assertEquals($this->randomRel, $this->link->rel);
    }

    public function test_provided_href_property() {
        $this->assertEquals($this->randomHref, $this->link->href);
    }

    public function test_provides_allowedMethod_property() {
        $this->assertEquals($this->randomAllowedMethods, $this->link->allowedMethods);
    }

    public function test_casting_to_string_converts_to_href() {
        $this->assertEquals($this->randomHref, (string)$this->link);
    }
}

