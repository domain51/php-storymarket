<?php

require_once dirname(dirname(dirname(__FILE__))) . '/bootstrap.php';

class Storymarket_Orgs_OrgManagerTest extends StorymarketTestCase {
    public function setUp() {
        $this->api = $this->getMockApi();
        $this->handler = $this->getMock('Storymarket_RequestHandler', array(),
            array($this->api, 'Storymarket_Base_Resource'));
    }

    public function test_is_subclass_of_base_manager() {
        $reflection = new ReflectionClass('Storymarket_Orgs_OrgManager');
        $this->assertTrue($reflection->isSubclassOf('Storymarket_Base_Manager'));
    }

    public function test_resourceClass_is_org() {
        $manager = new Storymarket_Orgs_OrgManager($this->api, $this->handler);
        $this->assertEquals('Storymarket_Orgs_Org', $manager->resourceClass);
    }

    public function test_all_requests_slash_orgs_slash() {
        $this->handler->expects($this->once())
            ->method('doList')
            ->with('/orgs/');

        $manager = new Storymarket_Orgs_OrgManager($this->api, $this->handler);
        $manager->all();
    }

    public function test_all_returns_value_from_handler() {
        $randomValue = rand(1000, 2000);
        $this->handler->expects($this->once())
            ->method('doList')
            ->with('/orgs/')
            ->will($this->returnValue($randomValue));

        $manager = new Storymarket_Orgs_OrgManager($this->api, $this->handler);
        $result = $manager->all();
        $this->assertEquals($randomValue, $result);
    }

    public function test_get_requests_slash_orgs_slash_resource_id() {
        $resource = $this->generateRandomResource();
        $this->handler->expects($this->once())
            ->method('doGet')
            ->with("/orgs/{$resource->id}/");

        $manager = new Storymarket_Orgs_OrgManager($this->api, $this->handler);
        $manager->get($resource);
    }

    public function test_get_returns_value_from_handler() {
        $randomValue = rand(1000, 2000);
        $resource = $this->generateRandomResource();
        $this->handler->expects($this->once())
            ->method('doGet')
            ->with("/orgs/{$resource->id}/")
            ->will($this->returnValue($randomValue));

        $manager = new Storymarket_Orgs_OrgManager($this->api, $this->handler);
        $result = $manager->get($resource);
        $this->assertEquals($randomValue, $result);
    }
}

