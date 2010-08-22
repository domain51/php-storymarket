<?php

require_once dirname(dirname(dirname(__FILE__))) . '/bootstrap.php';

class Storymarket_Base_ManagerTest extends StorymarketTestCase
{
    public function test_is_an_abstract() {
        $cls = new ReflectionClass(Storymarket_Base_Manager);
        $this->assertTrue($cls->isAbstract());
    }

    public function test_defines_get_abstract() {
        $func = new ReflectionMethod(Storymarket_Base_Manager, 'get');
        $this->assertTrue($func->isAbstract());
    }

    public function test_defines_all_abstract() {
        $func = new ReflectionMethod(Storymarket_Base_Manager, 'all');
        $this->assertTrue($func->isAbstract());
    }
}

