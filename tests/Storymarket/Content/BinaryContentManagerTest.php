<?php

require_once dirname(dirname(dirname(__FILE__))) . '/bootstrap.php';
require_once dirname(dirname(dirname(__FILE__))) . '/Storymarket/Base/ResourceTest.php';

class Storymarket_Content_BinaryContentManagerTest extends StorymarketTestCase {
    public function setUp() {
        $this->testFileLocation = STORYMARKET_TEST_PATH . '/support/logo.png';
        $this->randomUrlBit = 'rand_' . rand(10, 20);
        $this->api = $this->getMockApi();
        $this->handler = $this->getMock('Storymarket_RequestHandler', array(),
            array($this->api, 'Storymarket_Base_Resource'));
        $this->baseUrl = '/content/' . $this->randomUrlBit . '/';
    }

    public function createContentManager() {
        return new Storymarket_Content_BinaryContentManager(
            $this->api, $this->handler, $this->randomUrlBit);
    }

    // TODO: move to super-class
    public function generateRandomResource() {
        $data = array(
            'id' => rand(1000, 2000),
        );
        return new TestableResource($this->getManagerStub(), $data);
    }

    public function test_dispatches_to_handlers_uploadFile() {
        $resource = $this->generateRandomResource();
        $expectedUrl = '/content/' . $this->randomUrlBit . '/' . $resource->id . '/blob/';
        $this->handler->expects($this->once())
            ->method('doUploadFile')
            ->with($expectedUrl, $this->testFileLocation);

        $manager = $this->createContentManager();
        $manager->uploadFile($resource, $this->testFileLocation);
    }

}

