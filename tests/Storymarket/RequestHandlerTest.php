<?php

require_once dirname(dirname(__FILE__)) . '/bootstrap.php';

class Storymarket_RequestHandlerTest extends StorymarketTestCase {
    public function getManagerStub() {
        $manager = parent::getManagerStub();
        $manager->resourceClass = 'Storymarket_Base_Resource';
        return $manager;
    }

    public function test_requires_a_StoryMarket_object() {
        $constructor = new ReflectionMethod('Storymarket_RequestHandler', '__construct');

        $params = $constructor->getParameters();
        $api = $params[0];

        $this->assertEquals('Storymarket', $api->getClass()->getName());
    }

    public function test_requires_a_manager() {
        $constructor = new ReflectionMethod('Storymarket_RequestHandler', '__construct');
        $params = $constructor->getParameters();
        $resourceClass = $params[1];
        $this->assertEquals('manager', $resourceClass->getName());
    }

    public function test_list_returns_array_from_client() {
        $random = array('id' => rand(100, 200));
        $api = $this->getMockApi();
        $api->client = $this->getMockClient($api);
        $api->client->expects($this->once())
            ->method('get')
            ->with('/content/' . $random['id'] . '/')
            ->will($this->returnValue(array($random)));
        $handler = new Storymarket_RequestHandler($api, $this->getManagerStub());

        $result = $handler->doList('/content/' . $random['id'] . '/');
        $this->assertType('array', $result);
        $this->assertEquals(1, count($result));
        $this->assertEquals($random['id'], $result[0]->id);
    }

    public function test_get_returns_a_resource() {
        $random = array('id' => rand(100, 200));
        $url = '/content/' . $random['id'] . '/';
        $api = $this->getMockApi();
        $api->client = $this->getMockClient($api);
        $api->client->expects($this->once())
            ->method('get')
            ->with($url)
            ->will($this->returnValue($random));

        $handler = new Storymarket_RequestHandler($api, $this->getManagerStub());
        $result = $handler->doGet($url);

        $this->assertType('Storymarket_Base_Resource', $result);
        $this->assertEquals($random['id'], $result->id);
    }

    public function test_create_returns_a_resource() {
        $body = array('id' => rand(100, 200));
        $url = '/content/foobar/';

        $api = $this->getMockApi();
        $api->client = $this->getMockClient($api);
        $api->client->expects($this->once())
            ->method('post')
            ->with($url, $body)
            ->will($this->returnValue($body));

        $handler = new Storymarket_RequestHandler($api, $this->getManagerStub());
        $result = $handler->doCreate($url, $body);

        $this->assertType('Storymarket_Base_Resource', $result);
        $this->assertEquals($body['id'], $result->id);
    }

    public function test_delete_calls_delete_on_provided_client() {
        $url = '/content/' . rand(100, 200) . '/';
        $api = $this->getMockApi();
        $api->client = $this->getMockClient($api);
        $api->client->expects($this->once())
            ->method('delete')
            ->with($url);

        $handler = new Storymarket_RequestHandler($api, $this->getManagerStub());
        $handler->doDelete($url);
    }

    public function test_doUpdate_called_put_on_provided_client() {
        $body = array('id' => rand(100, 200));
        $url = '/content/' . $body['id'] . '/';
        $api = $this->getMockApi();
        $api->client = $this->getMockClient($api);
        $api->client->expects($this->once())
            ->method('put')
            ->with($url, $body);

        $handler = new Storymarket_RequestHandler($api, $this->getManagerStub());
        $handler->doUpdate($url, $body);
    }

    public function test_doFileUpload_calls_put_with_provided_file_as_blob() {
        $testFileLocation = STORYMARKET_TEST_PATH . '/support/logo.png';
        $body = array('id' => rand(100, 200));
        $url = '/content/' . $body['id'] . '/blob/';

        $data = array('blob' => base64_encode(file_get_contents($testFileLocation)));

        $api = $this->getMockApi();
        $api->client = $this->getMockClient($api);
        $api->client->expects($this->once())
            ->method('put')
            ->with($url, $data);

        $handler = new Storymarket_RequestHandler($api, $this->getManagerStub());
        $handler->doFileUpload($url, $testFileLocation);
    }
}

