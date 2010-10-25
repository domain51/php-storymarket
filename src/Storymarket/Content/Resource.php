<?php

class Storymarket_Content_Resource extends Storymarket_Base_Resource {
    public function __get($key) {
        $data = parent::__get($key);
        if (empty($data)) {
            return $data;
        }
        switch ($key) {
        case 'author':
        case 'uploaded_by':
        case 'uploadedBy':
            return new Storymarket_Content_User($data);
            break;

        case 'category':
            return new Storymarket_Categories_Category($this->manager->_api->categories, $data);
            break;

        case 'org':
            return new Storymarket_Orgs_Org($this->manager->_api->orgs, $data);
            break;
        }
        return $data;
    }

    public function __isset($key) {
        $acceptable = array('author', 'category', 'org',
            'pricing_scheme', 'pricingScheme',
            'rights_scheme', 'rightsScheme',
            'uploaded_by', 'uploadedBy',
        );
        return in_array($key, $acceptable);
    }

    public function save() {
        $this->manager->update($this);
    }

    public function delete() {
        $this->manager->delete($this);
    }
}
