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

    public function getResourceStub() {
        return $this->getMock('Storymarket_Base_Resource', array(), array($this->getManagerStub()));
    }

    public function assertClassAvailable($className) {
        $this->assertTrue(
            class_exists($className),
            "Checking that {$className} is available"
        );
    }

    public function assertSubclassOf($className, $superClass) {
        $reflection = new ReflectionClass($className);
        $this->assertTrue($reflection->isSubClassOf($superClass),
            "Checking that {$className} is a sub-class of {$superClass}");
    }

    public function assertAttributeExists($obj, $attr) {
        $this->assertTrue(isset($obj->$attr));
    }

    public function assertAttributeDoesNotExist($obj, $attr) {
        $this->assertFalse(isset($obj->$attr));
    }

    // TODO: move to super-class
    public function generateRandomResource() {
        require_once dirname(__FILE__) . '/Storymarket/Base/ResourceTest.php';
        $data = array(
            'id' => rand(1000, 2000),
        );
        return new TestableResource($this->getManagerStub(), $data);
    }

}

class StorymarketContentStubTests extends StorymarketTestCase {
    public $expectedSubclasses = array();

    public function setUp() {
        $this->expectedSubclasses[] = 'Storymarket_Content_Resource';
    }

    public function test() {
        $className = 'Storymarket_Content_' . $this->type;

        $this->assertClassAvailable($className);
        foreach ($this->expectedSubclasses as $expectedSubclass) {
            $this->assertSubclassOf($className, $expectedSubclass);
        }
    }
}

class StorymarketBinaryContentStubTests extends StorymarketContentStubTests {
    public function setUp() {
        parent::setUp();
        $this->expectedSubclasses[] = 'Storymarket_Content_BinaryContentResource';
    }
}

class StorymarketContentManagerTests extends StorymarketTestCase {
    public function setUp() {
        $this->classBeingTested = str_replace('Test', '', get_class($this));
    }

    public function testIsAvailable() {
        $this->assertClassAvailable($this->classBeingTested);
    }

    public function testIsAContentManager() {
        $this->assertSubclassOf(
            $this->classBeingTested,
            'Storymarket_Content_ContentManager');
    }

    public function testHasExpectedUrlbit() {
        $explodedClass = explode('_', $this->classBeingTested);
        $expectedUrlbit = strtolower(str_replace('Manager', '', array_pop($explodedClass)));

        $manager = new $this->classBeingTested($this->getMockApi());
        $this->assertEquals($expectedUrlbit, $manager->_url_bit);
    }

    public function testHasExpectedResourceClass() {
        $expectedResourceClass = str_replace('Manager', '', $this->classBeingTested);
        $manager = new $this->classBeingTested($this->getMockApi());
        $this->assertEquals($expectedResourceClass, $manager->resourceClass);
    }

}

class StorymarketBinaryContentManagerTests extends StorymarketContentManagerTests {
    public function testIsABinaryContentManager() {
        $this->assertSubclassOf(
            $this->classBeingTested,
            'Storymarket_Content_BinaryContentManager');
    }
}
