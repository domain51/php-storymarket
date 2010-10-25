<?php

require_once dirname(dirname(dirname(__FILE__))) . '/bootstrap.php';

class Storymarket_Schemes_PricingSchemeManagerTest extends
    Storymarket_Schemes_BaseSchemeManagerTest {
    public function test_specifies_PricingScheme_as_its_resourceClass() {
        $manager = new Storymarket_Schemes_PricingSchemeManager($this->getMockApi());
        $this->assertEquals('Storymarket_Schemes_PricingScheme', $manager->_resourceClass);
    }

    public function test_specifies_pricing_as_its_urlBit() {
        $manager = new Storymarket_Schemes_PricingSchemeManager($this->getMockApi());
        $this->assertEquals('pricing', $manager->_url_bit);
    }
}

