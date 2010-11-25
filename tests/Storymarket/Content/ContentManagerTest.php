<?php

require_once dirname(dirname(dirname(__FILE__))) . '/bootstrap.php';

class Storymarket_Content_ContentManagerTest extends StorymarketTestCase {
    public function setUp() {
        $this->randomUrlBit = 'rand_' . rand(10, 20);
        $this->api = $this->getMockApi();
        $this->handler = $this->getMock('Storymarket_RequestHandler', array(),
            array($this->api, 'Storymarket_Base_Resource'));
        $this->baseUrl = '/content/' . $this->randomUrlBit . '/';
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

    public function test_creates_own_request_handler_if_none_provided() {
        $manager = new Storymarket_Content_ContentManager($this->api);
        $this->assertType('Storymarket_RequestHandler', $manager->_handler);
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

    public function test_get_dispatches_to_doGet_with_id() {
        $id = rand(1000, 2000);
        $this->assertMethodDispatchesAsExpected('get', 'doGet',
            array($this->baseUrl . $id . '/'), array($id));
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
        $resource->id = $randomArray['id'];

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

    public function test_update_uses_provided_data_if_available() {
        $data = array(
            'id' => 'foo',
            'random' => rand(100, 200),
        );

        $resource = array(
            'id' => 'foo',
            'random' => rand(2000, 3000),
        );

        $this->handler->expects($this->once())
            ->method('doUpdate')
            ->with($this->baseUrl . $resource['id'] . '/', $data);

        $manager = $this->createContentManager();
        $manager->update($resource, $data);
    }

    public function test_update_turns_a_resource_into_an_array_before_handling_off_to_doUpdate() {
        $data = array(
            'id' => rand(100, 200),
            'title' => 'Some randon title: ' . rand(100, 200),
        );

        $resource = $this->getMock('Storymarket_Base_Resource', array(), array(
            $this->getManagerStub(), array()
        ));
        foreach($data as $k => $v) {
            $resource->$k = $v;
        }

        $expectedData = $data;
        unset($expectedData['id']);
        $this->handler->expects($this->once())
            ->method('doUpdate')
            ->with($this->baseUrl . $data['id'] . '/', $expectedData);

        $manager = $this->createContentManager();
        $manager->update($resource);
    }

    public function test_update_returns_doUpdate_result() {
        $this->assertMethodReturnsAsExpected('update', 'doUpdate', array(
            $this->generateRandomResource()));
    }

    public function assertValueConvertedToUrl($key, $expectedUrl) {
        $mock = $this->getResourceStub();
        $mock->id = rand(100, 200);
        $data = array(
            $key => $mock,
        );

        $actual = $this->createContentManager()->toArray($data);
        $this->assertEquals(sprintf($expectedUrl, $mock->id), $actual[$key]);
    }

    public function assertValueLeftAlone($key) {
        $random = rand(100, 200);
        $data = array(
            $key => $random,
        );

        $actual = $this->createContentManager()->toArray($data);
        $this->assertEquals("{$random}", $actual[$key]);
    }

    public function test_toArray_leaves_org_alone_if_not_an_object() {
        $this->assertValueLeftAlone("org");
    }

    public function test_toArray_changes_org_object_to_url() {
        $this->assertValueConvertedToUrl("org", "/orgs/%d/");
    }

    public function test_toArray_leaves_category_alone_if_not_an_object() {
        $this->assertValueLeftAlone('category');
    }

    public function test_toArray_changes_category_object_to_url() {
        $this->assertValueConvertedToUrl("category", "/content/sub_category/%d/");
    }

    public function test_toArray_leaves_pricing_scheme_alone_if_not_an_object() {
        $this->assertValueLeftAlone('pricing_scheme');
    }

    public function test_toArray_changes_pricing_scheme_object_to_url() {
        $this->assertValueConvertedToUrl("pricing_scheme", "/pricing/%d/");
    }

    public function test_toArray_leaves_rights_scheme_along_if_not_an_object() {
        $this->assertValueLeftAlone('rights_scheme');
    }

    public function test_toArray_changes_rights_scheme_object_to_url() {
        $this->assertValueConvertedToUrl("rights_scheme", "/rights/%d/");
    }

    public function test_toArray_leaves_tags_alone_if_not_an_array() {
        $this->assertValueLeftAlone('tags');
    }

    public function test_toArray_changes_tags_to_comma_separated_string() {
        $tags = array('foo', 'bar', 'random_' . rand(100, 200));
        $data = array(
            'tags' => $tags,
        );

        $actual = $this->createContentManager()->toArray($data);
        $this->assertEquals(implode(', ', $tags), $actual['tags']);
    }

    public function test_toArray_converts_any_User_object_to_username() {
        $username = "random-" . rand(100, 200);
        $user = new Storymarket_Content_User(array('username' => $username));

        $randomKey = 'foo-' . rand(100, 200);
        $data = array(
            $randomKey => $user,
        );

        $actual = $this->createContentManager()->toArray($data);
        $this->assertEquals($username, $actual[$randomKey]);
    }
}

