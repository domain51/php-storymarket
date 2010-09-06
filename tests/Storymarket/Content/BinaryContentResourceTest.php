<?php

require_once dirname(dirname(dirname(__FILE__))) . '/bootstrap.php';

class Storymarket_Content_BinaryContentResourceTest extends StorymarketTestCase {
    public function setUp() {
        $this->testFileLocation = STORYMARKET_TEST_PATH . '/support/logo.png';
    }

    public function test_uploadFile_dispatches_to_manager() {
        $manager = $this->getMock('Storymarket_Content_BinaryContentManager', array(),
            array($this->getMockApi(), 'Storymarket_Content_BinaryContentResource')
        );
        $manager->expects($this->once())
            ->method('uploadFile')
            ->with($this->testFileLocation);

        $binary = new Storymarket_Content_BinaryContentResource($manager, array());
        $binary->uploadFile($this->testFileLocation);
    }
}

