<?php

require_once dirname(dirname(dirname(__FILE__))) . '/bootstrap.php';

class TestableResource extends Storymarket_Base_Resource {
}

class Storymarket_Base_ResourceTest extends StorymarketTestCase {
    public function test_is_an_abstract() {
        $cls = new ReflectionClass(Storymarket_Base_Manager);
        $this->assertTrue($cls->isAbstract());
    }

    public function test_works_as_a_dumb_container() {
        $values = array(
            'key' => 'some random key' . rand(100, 1000),
            'name' => 'Bob Journalist',
        );

        $resource = new TestableResource($this->getManagerStub(), $values);
        foreach ($values as $k => $v) {
            $this->assertEquals($v, $resource->$k);
        }
    }

    public function test_camelCase_or_underscored_values_are_identical() {
        $values = array(
            'some_random_key' => rand(100, 200),
        );

        $resource = new TestableResource($this->getManagerStub(), $values);
        $this->assertEquals($resource->some_random_key, $resource->someRandomKey);
    }

    public function test_get_dispatches_to_manager() {
        $random_value = 'some randomly generated value ' . rand(1000, 2000);
        $manager = $this->getManagerStub();
        $manager->expects($this->once())
            ->method('get')
            ->will($this->returnValue($random_value));

        $resource = new TestableResource($manager, array());
        $this->assertEquals($random_value, $resource->get());
    }

    public function test_toArray_returns_raw_array() {
        $randomArray = array('id' => rand(100, 200));
        $resource = new TestableResource($this->getManagerStub(), $randomArray);
        $this->assertEquals($randomArray, $resource->toArray());
    }
}

