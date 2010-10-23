<?php

class Storymarket_Orgs_OrgManager extends Storymarket_Base_Manager {
    public $resourceClass = 'Storymarket_Orgs_Org';

    public function all() {
        return $this->_handler->doList('/orgs/');
    }

    public function get($resource) {
        return $this->_handler->doGet("/orgs/{$resource->id}/");
    }
}

