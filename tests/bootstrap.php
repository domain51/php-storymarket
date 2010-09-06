<?php

set_include_path(
    dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'src' . PATH_SEPARATOR .
    get_include_path()
);

define('STORYMARKET_TEST_PATH', dirname(__FILE__));

require 'Storymarket.php';


class StorymarketTestCase extends PHPUnit_Framework_TestCase
{
    public function getMockApi() {
        return $this->getMock('Storymarket', array(), array('123'));
    }

    public function getMockClient($api = null) {
        return $this->getMock('Storymarket_Client', array(),
            array((empty($api) ? $this->getMockApi() : $api)));
    }

    public function getManagerStub() {
        return $this->getMock('Storymarket_Base_Manager', array(), array($this->getMockApi()));
    }
}

class StorymarketContentStubTests extends StorymarketTestCase {
    public $expectedSubclass = 'Storymarket_Base_Resource';
    public function test() {
        $className = 'Storymarket_Content_' . $this->type;

        $this->assertTrue(class_exists($className), "Checking that {$className} is available");
        $reflection = new ReflectionClass($className);
        $this->assertTrue($reflection->isSubClassOf($this->expectedSubclass),
            "Checking that {$className} is a sub-class of {$this->expectedSubclass}");
    }
}

class StorymarketBinaryContentStubTests extends StorymarketContentStubTests {
    public $expectedSubclass = 'Storymarket_Content_BinaryContentResource';
}

