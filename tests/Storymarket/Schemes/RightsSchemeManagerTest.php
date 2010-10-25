<?php

require_once dirname(dirname(dirname(__FILE__))) . '/bootstrap.php';

class Storymarket_Schemes_RightsSchemeManagerTest extends
    Storymarket_Schemes_BaseSchemeManagerTest {
    public function test_specifies_RightsScheme_as_its_resourceClass() {
        $manager = new Storymarket_Schemes_RightsSchemeManager($this->getMockApi());
        $this->assertEquals('Storymarket_Schemes_RightsScheme', $manager->_resourceClass);
    }

    public function test_specifies_pricing_as_its_urlBit() {
        $manager = new Storymarket_Schemes_RightsSchemeManager($this->getMockApi());
        $this->assertEquals('rights', $manager->_url_bit);
    }
}

