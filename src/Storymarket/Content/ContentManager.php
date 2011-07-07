<?php

class Storymarket_Content_ContentManager extends Storymarket_Base_Manager {
    public $_api = null;
    public $resourceClass = null;
    public $_handler = null;
    public $_url_bit = null;
    public $_flattenFields = array(
        'category',
        'sub_type',
        'author',
        'title',
        'org',
        'tags',
    );

    public function __construct($api, $handler=null, $url_bit=null) {
        parent::__construct($api, $handler);
        $this->_url_bit = $url_bit;
        $className = get_class($this);
        if (is_null($this->_url_bit)) {
            $exploded = explode('_', $className);
            $this->_url_bit = strtolower(str_replace('Manager', '', array_pop($exploded)));
        }

        if (empty($this->resourceClass)) {
            $this->resourceClass = substr($className, 0, -7);
        }
    }

    protected function _buildUrl() {
        $args = func_get_args();
        $extra = !empty($args) ? implode('/', $args) . '/' : '';
        return sprintf('/content/%s/%s', $this->_url_bit, $extra);
    }

    public function all() {
        return $this->_handler->doList($this->_buildUrl());
    }

    public function get($resource) {
        $id = is_object($resource) ? $resource->id : $resource;
        return $this->_handler->doGet($this->_buildUrl($id));
    }

    public function delete($resource) {
        return $this->_handler->doDelete($this->_buildUrl($resource->id));
    }

    public function create($resource) {
        $data = $this->toArray($resource);
        return $this->_handler->doCreate($this->_buildUrl(), $data);
    }

    public function update($resource, $data=null) {
        if (is_null($data)) {
            $data = $resource;
        }
        $resourceId = is_array($resource) ? $resource['id'] : $resource->id;
        $data = $this->toArray($data);
        return $this->_handler->doUpdate($this->_buildUrl($resourceId), $data);
    }

    public function toArray($resource) {
        if (is_subclass_of($resource, 'Storymarket_Base_Resource')) {
            $data = array();
            foreach ($this->_flattenFields as $k) {
                if (!empty($resource->$k)) {
                    $data[$k] = $resource->$k;
                }
            }
        } else {
            $data = $resource;
        }

        # Now convert objects into URLs and other simplified notation
        foreach ($data as $key => $value) {
            if ($key === 'tags' && is_array($value)) {
                $data[$key] = implode(', ', $value);
                continue;
            }

            if (!is_object($value)) {
                continue;
            }

            if (is_a($value, 'Storymarket_Content_User')) {
                $data[$key] = $value->username;
                continue;
            }

            switch ($key) {
            case 'org':
                $data['org'] = '/orgs/' . $value->id . '/';
                break;
            case 'category':
                $data['category'] = "/content/sub_category/{$value->id}/";
                break;
            case 'sub_type':
                $data['sub_type'] = "/content/sub_type/{$value->id}/";
                break;

            case 'pricing_scheme':
                $data['pricing_scheme'] = "/pricing/{$value->id}/";
                break;

            case 'rights_scheme':
                $data[$key] = "/rights/{$value->id}/";
                break;
            }
        }
        return $data;
    }
}
