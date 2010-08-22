<?php

require_once dirname(dirname(__FILE__)) . '/bootstrap.php';

class Storymarket_ExceptionsTest extends StorymarketTestCase {
    public function test_is_an_exception() {
        $cls = new ReflectionClass(Storymarket_Exceptions);
        $this->assertTrue($cls->isSubclassOf('Exception'));
    }

    public function test_getStatus_equals_getCode() {
        $status = rand(450, 500);
        $exception = new Storymarket_Exceptions(null, $status);
        $this->assertEquals($status, $exception->getCode());
        $this->assertEquals($status, $exception->getStatus());
    }

    public function test_getBody_returns_optional_third_parameter() {
        $status = rand(450, 500);
        $body = 'some random body: ' . $status;
        $exception = new Storymarket_Exceptions(null, $status, $body);
        $this->assertEquals($body, $exception->getBody());
    }

    public function test_has_static_fromResponse_for_loading() {
        $status = rand(450, 500);
        $body = 'some random body: ' . $status;

        $exception = Storymarket_Exceptions::fromResponse($status, $body);
        $this->assertThat($exception, $this->isInstanceOf(Storymarket_Exceptions));
        $this->assertEquals($status, $exception->getStatus());
        $this->assertEquals($body, $exception->getBody());
    }

}
