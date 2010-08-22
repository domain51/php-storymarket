<?php

set_include_path(
    dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'src' . PATH_SEPARATOR .
    get_include_path()
);

require 'Storymarket.php';


class StorymarketTestCase extends PHPUnit_Framework_TestCase
{
    public function getMockApi() {
        return $this->getMock('Storymarket', array(), array('123'));
    }

    public function getManagerStub() {
        return $this->getMock('Storymarket_Base_Manager', array(), array($this->getMockApi()));
    }
}
