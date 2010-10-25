<?php

require_once dirname(dirname(dirname(__FILE__))) . '/bootstrap.php';

class Storymarket_Schemes_BaseSchemeManagerTest extends Storymarket_Base_ManagerTest {
    public $baseUrl = '//';
    public function setUp() {
        $this->classUnderTest = substr(get_class($this), 0, -4);
        $this->api = $this->getMockApi();
        $this->handler = $this->getMock('Storymarket_RequestHandler', array(),
            array($this->api, 'Storymarket_Base_Resource'));
    }

    public function createManager() {
        return new $this->classUnderTest($this->api, $this->handler);
    }

    public function assertMethodReturnsAsExpected($method, $handlerMethod, $args=array()) {
        $random = rand(1000, 2000);
        $this->handler->expects($this->once())
            ->method($handlerMethod)
            ->will($this->returnValue($random));

        $manager = $this->createManager();
        $this->assertEquals($random,
            call_user_func_array(array($manager, $method), $args));
    }

    public function assertMethodDispatchesAsExpected($method, $handlerMethod, $urlArgs=array(), $args=array()) {
        $m = $this->handler->expects($this->once())
            ->method($handlerMethod);
        call_user_func_array(array($m, 'with'), $urlArgs);

        $manager = $this->createManager();
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
}

