<?php

class Storymarket_RequestHandler {
    public function __construct(Storymarket $api, $manager) {
        $this->api = $api;
        $this->manager = $manager;
    }

    public function doList($url) {
        $resources = $this->api->client->get($url);
        $return = array();
        foreach ($resources as $resource) {
            $return[] = new $this->manager->resourceClass($this->manager, $resource);
        }
        return $return;
    }

    public function doGet($url) {
        $resource = $this->api->client->get($url);
        return new $this->manager->resourceClass($this->manager, $resource);
    }

    public function doDelete($url) {
        $this->api->client->delete($url);
    }

    public function doCreate($url, $data) {
        $resource = $this->api->client->post($url, $data);
        return new $this->manager->resourceClass($this->manager, $resource);
    }

    public function doUpdate($url, $data) {
        $this->api->client->put($url, $data);
    }
}
