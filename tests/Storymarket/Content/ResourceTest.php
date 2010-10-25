<?php

require_once dirname(dirname(dirname(__FILE__))) . '/bootstrap.php';

class Storymarket_Content_ResourceTest extends Storymarket_Base_ResourceTest {
    public function assertAttributeExists($attr) {
        $resource = new Storymarket_Content_Resource($this->getManagerStub(), array());
        parent::assertAttributeExists($resource, $attr);
    }

    public function generateResource($data = array()) {
        return new Storymarket_Content_Resource($this->getManagerStub(), $data);
    }

    public function test_exists() {
        $this->assertTrue(class_exists('Storymarket_Content_Resource'));
    }

    public function test_extends_base_resource() {
        $this->assertSubclassOf('Storymarket_Content_Resource', 'Storymarket_Base_Resource');
    }

    public function test_returns_false_for_random_attribute() {
        $resource = $this->generateResource();
        $this->assertAttributeDoesNotExist($resource, 'unknown');
    }

    public function test_has_an_author_attribute() {
        $this->assertAttributeExists('author');
    }

    public function test_author_attribute_is_null_by_default() {
        $resource = $this->generateResource();
        $this->assertNull($resource->author);
    }

    public function test_author_returns_a_User_object_for_author_if_present_in_data() {
        $randomAuthor = 'joe-author-' . rand(100, 200);
        $resource = $this->generateResource(array(
            'author' => array(
                'username' => $randomAuthor,
                'first_name' => 'Joe',
                'last_name' => 'Random',
                'email' => '',
            )
        ));
        $this->assertType(Storymarket_Content_User, $resource->author);
        $this->assertEquals($randomAuthor, $resource->author->username);
    }

    public function test_has_a_category_attribute() {
        $this->assertAttributeExists('category');
    }

    public function test_category_attribute_is_null_by_default() {
        $this->assertNull($this->generateResource()->category);
    }

    public function test_category_returns_a_Category_object_for_category_if_present_in_data() {
        $randomCategory = 'category-' . rand(100, 200);
        $resource = $this->generateResource(array(
            'category' => array(
                'random' => $randomCategory,
            ),
        ));

        $this->assertType(Storymarket_Categories_Category, $resource->category);
        $this->assertType(Storymarket_Categories_CategoryManager, $resource->category->manager);
        $this->assertEquals($randomCategory, $resource->category->random);
    }

    public function test_has_an_org_attribute() {
        $this->assertAttributeExists('org');
    }

    public function test_org_attribute_is_null_by_default() {
        $this->assertNull($this->generateResource()->org);
    }

    public function test_org_returns_an_Org_object_for_org_if_present_in_data() {
        $randomOrg = 'org-' . rand(1000, 2000);
        $resource = $this->generateResource(array(
            'org' => array(
                'random' => $randomOrg,
            ),
        ));

        $this->assertType(Storymarket_Orgs_Org, $resource->org);
        $this->assertType(Storymarket_Orgs_OrgManager, $resource->org->manager);
        $this->assertEquals($randomOrg, $resource->org->random);
    }

    public function test_has_a_pricingScheme_attribute() {
        $this->assertAttributeExists('pricingScheme');
    }

    public function test_pricingScheme_attribute_is_null_by_default() {
        $this->assertNull($this->generateResource()->pricingScheme);
    }

    public function generateResourceWithRandomPricingScheme() {
        $randomScheme = 'pricing-scheme-' . rand(100, 200);
        $resource = $this->generateResource(array(
            'pricing_scheme' => array(
                'random' => $randomScheme,
            )
        ));
        return array($randomScheme, $resource);
    }

    public function test_pricingScheme_returns_a_PricingScheme_object_if_present_in_data() {
        list($randomScheme, $resource) = $this->generateResourceWithRandomPricingScheme();

        $this->markTestIncomplete('need to implement PricingScheme object');
        $this->assertType(Storymarket_Schemes_PricingScheme, $resource->pricingScheme);
        $this->assertType(Storymarket_Schemes_PricingSchemeManager, $resource->pricingScheme->manager);
        $this->assertEquals($randomScheme, $resource->pricingScheme->random);
    }

    public function test_has_a_pricing_scheme_attribute() {
        $this->assertAttributeExists('pricing_scheme');
    }

    public function test_pricing_scheme_and_pricingScheme_are_identical() {
        list($randomScheme, $resource) = $this->generateResourceWithRandomPricingScheme();
        $this->assertEquals($resource->pricingScheme, $resource->pricing_scheme);
    }

    public function test_has_a_rightsScheme_attribute() {
        $this->assertAttributeExists('rightsScheme');
    }

    public function test_has_a_rights_scheme_attribute() {
        $this->assertAttributeExists('rights_scheme');
    }

    public function generateResourceWithRandomRightsScheme() {
        $randomScheme = 'rights-scheme-' . rand(100, 200);
        $resource = $this->generateResource(array(
            'rights_scheme' => array(
                'random' => $randomScheme,
            )
        ));
        return array($randomScheme, $resource);
    }

    public function test_rights_scheme_and_rightsScheme_are_identical() {
        list($randomScheme, $resource) = $this->generateResourceWithRandomRightsScheme();
        $this->assertEquals($resource->rightsScheme, $resource->rights_scheme);
    }

    public function test_rightsScheme_returns_a_RightsScheme_object_if_present_in_data() {
        list($randomScheme, $resource) = $this->generateResourceWithRandomRightsScheme();

        $this->markTestIncomplete('need to implement RightsScheme object');
        $this->assertType(Storymarket_Schemes_RightsScheme, $resource->rightsScheme);
        $this->assertType(Storymarket_Schemes_RightsSchemeManager, $resource->rightsScheme->manager);
        $this->assertEquals($randomScheme, $resource->rightsScheme->random);
    }

    public function test_has_an_uploadedBy_attribute() {
        $this->assertAttributeExists('uploadedBy');
    }

    public function test_has_an_uploaded_by_attribute() {
        $this->assertAttributeExists('uploaded_by');
    }

    public function generateResourceWithRandomUploadedBy() {
        $randomAuthor = 'joe-author-' . rand(100, 200);
        $resource = $this->generateResource(array(
            'uploaded_by' => array(
                'username' => $randomAuthor,
                'first_name' => 'Joe',
                'last_name' => 'Random',
                'email' => '',
            )
        ));

        return array($randomAuthor, $resource);
    }

    public function test_uploadedBy_attribute_is_a_User_if_present() {
        list($randomAuthor, $resource) = $this->generateResourceWithRandomUploadedBy();

        $this->assertType(Storymarket_Content_User, $resource->uploadedBy);
        $this->assertEquals($randomAuthor, $resource->uploadedBy->username);
    }

    public function test_uploadedBy_and_uploaded_by_are_the_same() {
        list($randomAuthor, $resource) = $this->generateResourceWithRandomUploadedBy();
        $this->assertEquals($resource->uploadedBy, $resource->uploaded_by);
    }
}
