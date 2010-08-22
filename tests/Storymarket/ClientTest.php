<?php

require_once dirname(dirname(__FILE__)) . '/bootstrap.php';

class Storymarket_ClientTest extends StorymarketTestCase {
    public function assertExpectedDispatch($method) {
        $url = '/content/' . rand(10, 20) . '/';
        $expected_return = 'some randomly generated return' . rand(1000, 2000);

        $client = $this->getMock('Storymarket_Client', array('request'), array($this->getMockApi()));
        $client->expects($this->once())
            ->method('request')
            ->with($url, strtoupper($method))
            ->will($this->returnValue($expected_return));

        $return = $client->$method($url);
        $this->assertEquals($expected_return, $return);
    }

    public function test_get_dispatches_to_request_and_returns_the_result() {
        $this->assertExpectedDispatch('get');
    }

    public function test_post_dispatches_to_request_and_returns_the_result() {
        $this->assertExpectedDispatch('post');
    }

    public function test_put_dispatches_to_request_and_returns_the_result() {
        $this->assertExpectedDispatch('put');
    }

    public function test_delete_dispatches_to_request_and_returns_the_result() {
        $this->assertExpectedDispatch('delete');
    }

    public function test_has_a_userAgent_property() {
        $client = new Storymarket_Client($this->getMockApi());
        $this->assertTrue(isset($client->userAgent));
    }

    public function test_userAgent_property_is_equal_to_php_storymarket_plus_current_version() {
        $client = new Storymarket_Client($this->getMockApi());
        $this->assertEquals('php-storymarket/' . Storymarket::VERSION, $client->userAgent);
    }

    public function test_has_baseUrl_property() {
        $client = new Storymarket_Client($this->getMockApi());
        $this->assertTrue(isset($client->baseUrl));
    }

    public function test_baseUrl_is_set_to_storymarket_url() {
        $client = new Storymarket_Client($this->getMockApi());
        $this->assertEquals('http://storymarket.com/api/v1', $client->baseUrl);
    }
}

