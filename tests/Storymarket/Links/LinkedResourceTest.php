<?php

require_once dirname(dirname(dirname(__FILE__))) . '/bootstrap.php';

class Storymarket_Links_LinkedResourceTest extends StorymarketTestCase {
    public function generateRandomInfo() {
        return array(
            'links' => array(
                array(
                    'rel' => 'some-rel',
                    'href' => 'some-href',
                    'allowed_methods' => 'some-allowed_methods',
                ),
                array(
                    'rel' => $random_rel,
                    'href' => $random_href,
                    'allowed_methods' => $random_allowed_methods,
                ),
            ),
        );
    }

    public function test_is_a_resource() {
        $reflection = new ReflectionClass('Storymarket_Links_LinkedResource');
        $this->assertTrue($reflection->isSubclassOf('Storymarket_Base_Resource'));
    }

    public function test_instantiates_like_a_normal_resource() {
        $resource = new Storymarket_Links_LinkedResource($this->getManagerStub());
        $this->assertTrue(true, "no error expected");
    }

    public function test_creates_links_the_same_length_as_those_passed_in() {
        $info = $this->generateRandomInfo();
        $resource = new Storymarket_Links_LinkedResource($this->getManagerStub(), $info);
        $this->assertEquals(count($info['links']), count($resource->links));
    }

    public function test_links_is_always_an_array() {
        $resource = new Storymarket_Links_LinkedResource(
            $this->getManagerStub(),
            $this->generateRandomInfo()
        );

        $this->assertType('array', $resource->links);
    }

    public function test_converts_all_links_over_to_link_objects() {
        $info = $this->generateRandomInfo();
        $resource = new Storymarket_Links_LinkedResource($this->getManagerStub(), $info);
        foreach ($resource->links as $link) {
            $this->assertType(Storymarket_Links_Link, $link);
        }
    }

    public function test_links_are_addressable_by_their_rel() {
        $info = $this->generateRandomInfo();
        $resource = new Storymarket_Links_LinkedResource($this->getManagerStub(), $info);
        foreach ($info['links'] as $expectedLink) {
            $this->assertTrue(isset($resource->links[$expectedLink['rel']]));
        }
    }

    public function test_links_contain_all_of_their_expected_data() {
        $info = $this->generateRandomInfo();
        $resource = new Storymarket_Links_LinkedResource($this->getManagerStub(), $info);
        foreach ($info['links'] as $expectedLink) {
            $link = $resource->links[$expectedLink['rel']];
            $this->assertEquals($expectedLink['rel'], $link->rel);
            $this->assertEquals($expectedLink['href'], $link->href);
            $this->assertEquals($expectedLink['allowed_methods'], $link->allowedMethods);
        }
    }
}

