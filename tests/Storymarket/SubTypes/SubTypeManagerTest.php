<?php

require_once dirname(dirname(dirname(__FILE__))) . '/bootstrap.php';

class Storymarket_SubTypes_SubTypeManagerTest extends StorymarketTestCase {
    public function setUp() {
        $this->api = $this->getMockApi();
        $this->handler = $this->getMock('Storymarket_RequestHandler', array(),
            array($this->api, 'Storymarket_Base_Resource'));
    }

    public function test_is_subclass_of_base_manager() {
        $reflection = new ReflectionClass('Storymarket_SubTypes_SubTypeManager');
        $this->assertTrue($reflection->isSubclassOf('Storymarket_Base_Manager'));
    }

    public function test_resourceClass_is_subtype() {
        $manager = new Storymarket_SubTypes_SubTypeManager($this->api, $this->handler);
        $this->assertEquals('Storymarket_SubTypes_SubType', $manager->resourceClass);
    }

    public function test_all_requests_slash_orgs_slash() {
        $this->handler->expects($this->once())
            ->method('doList')
            ->with('/content/sub_type/');

        $manager = new Storymarket_SubTypes_SubTypeManager($this->api, $this->handler);
        $manager->all();
    }

    public function test_all_returns_value_from_handler() {
        $randomValue = rand(1000, 2000);
        $this->handler->expects($this->once())
            ->method('doList')
            ->with('/content/sub_type/')
            ->will($this->returnValue($randomValue));

        $manager = new Storymarket_SubTypes_SubTypeManager($this->api, $this->handler);
        $result = $manager->all();
        $this->assertEquals($randomValue, $result);
    }

    public function test_get_requests_slash_content_slash_sub_type_slash_resource_id() {
        $resource = $this->generateRandomResource();
        $this->handler->expects($this->once())
            ->method('doGet')
            ->with("/content/sub_type/{$resource->id}/");

        $manager = new Storymarket_SubTypes_SubTypeManager($this->api, $this->handler);
        $manager->get($resource);
    }

    public function test_get_requests_slash_content_slash_subtype_slash_id() {
        $id = rand(1000, 2000);
        $this->handler->expects($this->once())
            ->method('doGet')
            ->with("/content/sub_type/{$id}/");

        $manager = new Storymarket_SubTypes_SubTypeManager($this->api, $this->handler);
        $manager->get($id);
    }

    public function test_get_returns_value_from_handler() {
        $randomValue = rand(1000, 2000);
        $resource = $this->generateRandomResource();
        $this->handler->expects($this->once())
            ->method('doGet')
            ->with("/content/sub_type/{$resource->id}/")
            ->will($this->returnValue($randomValue));

        $manager = new Storymarket_SubTypes_SubTypeManager($this->api, $this->handler);
        $result = $manager->get($resource);
        $this->assertEquals($randomValue, $result);
    }
}

