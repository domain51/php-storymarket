<?php

require_once dirname(dirname(dirname(__FILE__))) . '/bootstrap.php';

class Storymarket_Packages_PackageTest extends Storymarket_Content_ResourceTest {
    public function generateResource($data = array()) {
        return new Storymarket_Packages_Package($this->getManagerStub(), $data);
    }

    public function test_exists() {
        $this->assertTrue(class_exists('Storymarket_Packages_Package'));
    }

    public function test_is_a_subclass_of_Content_Resource() {
        $this->assertSubclassOf('Storymarket_Packages_Package', 'Storymarket_Content_Resource');
    }

    public function test_has_an_audioItems_attribute() {
        $this->assertAttributeExists('audioItems');
    }

    public function test_has_an_audio_items_attribute() {
        $this->assertAttributeExists('audio_items');
    }

    public function generateAudioContainingResource() {
        $data = array('audio_items' => array());
        for ($i = 0, $l = rand(2, 10); $i < $l; ++$i) {
            $data['audio_items'][] = array(
                'random' => rand(100, 200),
            );
        }
        return array($data, $this->generateResource($data));

    }

    public function test_audioItems_and_audio_items_are_identical() {
        list($randomData, $resource) = $this->generateAudioContainingResource();
        $this->assertEquals($resource->audioItems, $resource->audio_items);
    }

    public function test_audioItems_returns_an_array_of_Audio_objects_if_present() {
        list($randomData, $resource) = $this->generateAudioContainingResource();
        $this->assertTrue(is_array($resource->audioItems));

        $this->assertEquals(count($randomData['audio_items']),
            count($resource->audioItems));
        foreach ($resource->audioItems as $index => $audio) {
            $this->assertType(Storymarket_Content_Audio, $audio);
            $this->assertType(Storymarket_Content_AudioManager, $audio->manager);
            $this->assertEquals($randomData['audio_items'][$index]['random'],
                $audio->random);
        }
    }

    public function test_has_dataItems_attribute() {
        $this->assertAttributeExists('dataItems');
    }

    public function test_has_an_data_items_attribute() {
        $this->assertAttributeExists('data_items');
    }

    public function generateDataContainingResource() {
        $data = array('data_items' => array());
        for ($i = 0, $l = rand(2, 10); $i < $l; ++$i) {
            $data['data_items'][] = array(
                'random' => rand(100, 200),
            );
        }
        return array($data, $this->generateResource($data));

    }

    public function test_dataItems_and_data_items_are_identical() {
        list($randomData, $resource) = $this->generateDataContainingResource();
        $this->assertEquals($resource->dataItems, $resource->data_items);
    }

    public function test_dataItems_returns_an_array_of_Data_objects_if_present() {
        list($randomData, $resource) = $this->generateDataContainingResource();
        $this->assertTrue(is_array($resource->dataItems));

        $this->assertEquals(count($randomData['data_items']),
            count($resource->dataItems));
        foreach ($resource->dataItems as $index => $data) {
            $this->assertType(Storymarket_Content_Data, $data);
            $this->assertType(Storymarket_Content_DataManager, $data->manager);
            $this->assertEquals($randomData['data_items'][$index]['random'],
                $data->random);
        }
    }

    public function test_has_an_photoItems_attribute() {
        $this->assertAttributeExists('photoItems');
    }

    public function test_has_an_photo_items_attribute() {
        $this->assertAttributeExists('photo_items');
    }

    public function generatePhotoContainingResource() {
        $data = array('photo_items' => array());
        for ($i = 0, $l = rand(2, 10); $i < $l; ++$i) {
            $data['photo_items'][] = array(
                'random' => rand(100, 200),
            );
        }
        return array($data, $this->generateResource($data));

    }

    public function test_photoItems_and_photo_items_are_identical() {
        list($randomData, $resource) = $this->generatePhotoContainingResource();
        $this->assertEquals($resource->photoItems, $resource->photo_items);
    }

    public function test_photoItems_returns_an_array_of_Photo_objects_if_present() {
        list($randomData, $resource) = $this->generatePhotoContainingResource();
        $this->assertTrue(is_array($resource->photoItems));

        $this->assertEquals(count($randomData['photo_items']),
            count($resource->photoItems));
        foreach ($resource->photoItems as $index => $photo) {
            $this->assertType(Storymarket_Content_Photo, $photo);
            $this->assertType(Storymarket_Content_PhotoManager, $photo->manager);
            $this->assertEquals($randomData['photo_items'][$index]['random'],
                $photo->random);
        }
    }

    public function test_has_an_textItems_attribute() {
        $this->assertAttributeExists('textItems');
    }

    public function test_has_an_text_items_attribute() {
        $this->assertAttributeExists('text_items');
    }

    public function generateTextContainingResource() {
        $data = array('text_items' => array());
        for ($i = 0, $l = rand(2, 10); $i < $l; ++$i) {
            $data['text_items'][] = array(
                'random' => rand(100, 200),
            );
        }
        return array($data, $this->generateResource($data));

    }

    public function test_textItems_and_text_items_are_identical() {
        list($randomData, $resource) = $this->generateTextContainingResource();
        $this->assertEquals($resource->textItems, $resource->text_items);
    }

    public function test_textItems_returns_an_array_of_Text_objects_if_present() {
        list($randomData, $resource) = $this->generateTextContainingResource();
        $this->assertTrue(is_array($resource->textItems));

        $this->assertEquals(count($randomData['text_items']),
            count($resource->textItems));
        foreach ($resource->textItems as $index => $text) {
            $this->assertType(Storymarket_Content_Text, $text);
            $this->assertType(Storymarket_Content_TextManager, $text->manager);
            $this->assertEquals($randomData['text_items'][$index]['random'],
                $text->random);
        }
    }

    public function test_has_an_videoItems_attribute() {
        $this->assertAttributeExists('videoItems');
    }

    public function test_has_an_video_items_attribute() {
        $this->assertAttributeExists('video_items');
    }

    public function generateVideoContainingResource() {
        $data = array('video_items' => array());
        for ($i = 0, $l = rand(2, 10); $i < $l; ++$i) {
            $data['video_items'][] = array(
                'random' => rand(100, 200),
            );
        }
        return array($data, $this->generateResource($data));

    }

    public function test_videoItems_and_video_items_are_identical() {
        list($randomData, $resource) = $this->generateVideoContainingResource();
        $this->assertEquals($resource->videoItems, $resource->video_items);
    }

    public function test_videoItems_returns_an_array_of_Video_objects_if_present() {
        list($randomData, $resource) = $this->generateVideoContainingResource();
        $this->assertTrue(is_array($resource->videoItems));

        $this->assertEquals(count($randomData['video_items']),
            count($resource->videoItems));
        foreach ($resource->videoItems as $index => $video) {
            $this->assertType(Storymarket_Content_Video, $video);
            $this->assertType(Storymarket_Content_VideoManager, $video->manager);
            $this->assertEquals($randomData['video_items'][$index]['random'],
                $video->random);
        }
    }

}

