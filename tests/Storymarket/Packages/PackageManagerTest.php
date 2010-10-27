<?php

require_once dirname(dirname(dirname(__FILE__))) . '/bootstrap.php';

class DummyResource {
    public $id = null;
}

class Storymarket_Packages_PackageManagerTest
    extends Storymarket_Content_ContentManagerTest {

    public function assertExpectedItems($type) {
        $manager = new Storymarket_Packages_PackageManager($this->getMockApi());

        $data = array();
        for ($i = 0, $l = rand(2, 10); $i < $l; ++$i) {
            $obj = new DummyResource();
            $obj->id = rand(100, 200);
            $data["{$type}_items"][] = array($obj);
        }
        $resource = new Storymarket_Packages_Package($manager, $data);
        $result = $manager->toArray($resource);

        $this->assertEquals(count($data["{$type}_items"]), count($result["{$type}_items"]));
        foreach ($result["{$type}_items"] as $key => $item) {
            $expectedId = $data["{$type}_items"][$key]->id;
            $expected = "/content/{$type}/{$expectedId}/";
            $this->assertEquals($expected, $item);
        }
    }

    public function testAudioItemsAreCompressedWhenConvertingToArray() {
        $this->assertExpectedItems('audio');
    }

    public function testDataItemsAreFlattenedAsExpected() {
        $this->assertExpectedItems('data');
    }

    public function testPhotoItemsAreFlattenedAsExpected() {
        $this->assertExpectedItems('photo');
    }

    public function testTextItemsAreFlattenedAsExpected() {
        $this->assertExpectedItems('text');
    }

    public function testVideoItemsAreFlattenedAsExpected() {
        $this->assertExpectedItems('video');
    }
}

