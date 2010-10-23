<?php

/**
 * Super class for all specific Resource types
 *
 * @todo This should potentially implement ArrayAccess so you can use it like
 *       an associative array.  Not implementing in first pass, will later if
 *       it is requested.
 */
class Storymarket_Base_Resource
{
    protected $_info = array();

    public function __construct(Storymarket_Base_Manager $manager, $info=array()) {
        $this->manager = $manager;
        $this->_add_details($info);
    }

    /**
     * Internal hook for handling assigning of _info.
     *
     * Used in Resources that need to do any additional setup before
     * asdsigning _info.
     */
    protected function _add_details($info) {
        $this->_info = array_merge($this->_info, $info);
    }

    public function __get($k) {
        if (!isset($this->_info[$k])) {
            return null;
        }
        return $this->_info[$k];
    }

    public function get() {
        return $this->manager->get($this->id);
    }

    public function toArray() {
        return $this->_info;
    }
}

