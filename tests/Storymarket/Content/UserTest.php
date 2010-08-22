<?php

require_once dirname(dirname(dirname(__FILE__))) . '/bootstrap.php';

class Storymarket_Content_UserTest extends StorymarketTestCase {
    public function assertUserHasProperty($name) {
        $user = new Storymarket_Content_User();
        $this->assertTrue(isset($user->$name));
    }

    public function test_has_a_username_property() {
        $this->assertUserHasProperty('username');
    }

    public function test_has_a_first_name_property() {
        $this->assertUserHasProperty('first_name');
    }

    public function test_has_last_name_property() {
        $this->assertUserHasProperty('last_name');
    }

    public function test_has_email_property() {
        $this->assertUserHasProperty('email');
    }

    public function test_returns_false_for_other_random_properties() {
        $random_property_name = 'rand_' . rand(100, 200);
        $user = new Storymarket_Content_User();
        $this->assertFalse(isset($user->$random_property_name));
    }

    public function assertPropertySetOnConstruct($name, $value) {
        $data = array($name => $value);
        $user = new Storymarket_Content_User($data);
        $this->assertEquals($value, $user->$name);
    }

    public function test_sets_username_property_based_on_provided_array() {
        $random_username = 'random-username-' . rand(100, 200);
        $this->assertPropertySetOnConstruct('username', $random_username);
    }

    public function test_sets_first_name_property_based_on_provided_array() {
        $random_first_name = 'FirstName ' . rand(100, 200);
        $this->assertPropertySetOnConstruct('first_name', $random_first_name);
    }

    public function test_sets_last_name_property_based_on_provided_array() {
        $random_last_name = 'Last Name ' . rand(100, 200);
        $this->assertPropertySetOnConstruct('last_name', $random_last_name);
    }

    public function test_sets_email_property_based_on_provided_array() {
        $random_email = 'bob@' . rand(10, 20) . '.example.com';
        $this->assertPropertySetOnConstruct('email', $random_email);
    }

    public function test_ignores_properties_it_does_not_know_about() {
        $random_key = 'random_' . rand(10, 20);
        $user = new Storymarket_Content_User(array($random_key => 'will not be set'));
        $this->assertFalse(isset($user->$random_key));
    }
}

