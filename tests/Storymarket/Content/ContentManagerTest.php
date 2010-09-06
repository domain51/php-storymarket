<?php

require_once dirname(dirname(dirname(__FILE__))) . '/bootstrap.php';
require_once dirname(dirname(dirname(__FILE__))) . '/Storymarket/Base/ResourceTest.php';

class Storymarket_Content_ContentManagerTest extends StorymarketTestCase {
    public function setUp() {
        $this->randomUrlBit = 'rand_' . rand(10, 20);
        $this->api = $this->getMockApi();
        $this->handler = $this->getMock('Storymarket_RequestHandler', array(),
            array($this->api, 'Storymarket_Base_Resource'));
        $this->baseUrl = '/content/' . $this->randomUrlBit . '/';
    }

    // TODO: move to super-class
    public function generateRandomResource() {
        $data = array(
            'id' => rand(1000, 2000),
        );
        return new TestableResource($this->getManagerStub(), $data);
    }

    public function createContentManager() {
        return new Storymarket_Content_ContentManager(
            $this->api, $this->handler, $this->randomUrlBit);
    }

    public function assertMethodReturnsAsExpected($method, $handlerMethod, $args=array()) {
        $random = rand(1000, 2000);
        $this->handler->expects($this->once())
            ->method($handlerMethod)
            ->will($this->returnValue($random));

        $manager = $this->createContentManager();
        $this->assertEquals($random,
            call_user_func_array(array($manager, $method), $args));
    }

    public function assertMethodDispatchesAsExpected($method, $handlerMethod, $urlArgs=array(), $args=array()) {
        $m = $this->handler->expects($this->once())
            ->method($handlerMethod);
        call_user_func_array(array($m, 'with'), $urlArgs);

        $manager = $this->createContentManager();
        call_user_func_array(array($manager, $method), $args);
    }

    public function test_all_dispatches_to_doList() {
        $this->assertMethodDispatchesAsExpected('all', 'doList');
    }

    public function test_all_returns_doList_result() {
        $this->assertMethodReturnsAsExpected('all', 'doList');
    }

    public function test_get_dispatches_to_doGet() {
        $resource = $this->generateRandomResource();
        $this->assertMethodDispatchesAsExpected('get', 'doGet',
            array($this->baseUrl . $resource->id . '/'), array($resource));
    }

    public function test_get_returns_doGet_result() {
        $this->assertMethodReturnsAsExpected('get', 'doGet', array(
            $this->generateRandomResource()));
    }

    public function test_delete_dispatches_to_doDelete() {
        $resource = $this->generateRandomResource();
        $this->assertMethodReturnsAsExpected('delete', 'doDelete',
            array($this->baseUrl . $resource->id . '/'), array($resource));
    }

    public function test_delete_returns_doDelete_result() {
        $this->assertMethodReturnsAsExpected('delete', 'doDelete', array(
            $this->generateRandomResource()));
    }

    public function test_create_dispatches_to_doCreate() {
        $resource = array(
            'id' => 'foo',
            'name' => 'bar',
            'random' => rand(100, 200),
        );
        $this->handler->expects($this->once())
            ->method('doCreate')
            ->with('/content/' . $this->randomUrlBit . '/', $resource);

        $manager = $this->createContentManager();
        $manager->create($resource);
    }

    public function test_create_turns_a_resource_into_an_array_before_handing_off_to_doCreate() {
        $randomArray = array('id' => rand(100, 200));
        $resource = $this->getMock('Storymarket_Base_Resource', array(), array(
            $this->getManagerStub(), array()
        ));
        $resource->expects($this->once())
            ->method('toArray')
            ->will($this->returnValue($randomArray));

        $manager = $this->createContentManager();
        $manager->create($resource);
    }

    public function test_create_returns_doCreate_result() {
        $this->assertMethodReturnsAsExpected('create', 'doCreate', array(
            $this->generateRandomResource()));
    }

    public function test_update_dispatches_to_doUpdate() {
        $resource = array(
            'id' => 'foo',
            'name' => 'bar',
            'random' => rand(100, 200),
        );
        $this->handler->expects($this->once())
            ->method('doUpdate')
            ->with($this->baseUrl . $resource['id'] . '/', $resource);

        $manager = $this->createContentManager();
        $manager->update($resource);
    }

    public function test_update_turns_a_resource_into_an_array_before_handling_off_to_doUpdate() {
        $randomArray = array('id' => rand(100, 200));
        $resource = $this->getMock('Storymarket_Base_Resource', array(), array(
            $this->getManagerStub(), array()
        ));
        $resource->expects($this->once())
            ->method('toArray')
            ->will($this->returnValue($randomArray));

        $manager = $this->createContentManager();
        $manager->update($resource);
    }

    public function test_update_returns_doUpdate_result() {
        $this->assertMethodReturnsAsExpected('update', 'doUpdate', array(
            $this->generateRandomResource()));
    }
}

