<?php

// TODO: handle SPL autoload failure gracefully
function _storymarket_autoloader($class) {
    require str_replace('_', DIRECTORY_SEPARATOR, $class) . '.php';
}
spl_autoload_register(_storymarket_autoloader);

class Storymarket {
    const VERSION = '0.1.0';

    public $api_key = null;
    public $client = null;

    public function __construct($api_key) {
        $this->api_key = $api_key;
        $this->client = new Storymarket_Client($this);

        $this->audio = new Storymarket_Content_AudioManager($this);
        $this->categories = new Storymarket_Content_CategoryManager($this);
        $this->data = new Storymarket_Content_Data($this);
        $this->orgs = new Storymarket_Orgs_OrgManager($this);
        $this->photos = new Storymarket_Content_PhotoManager($this);
        $this->pricing = new Storymarket_Schemes_PricingSchemeManager($this);
        $this->rights = new Storymarket_Schemes_RightsSchemeManager($this);
    }
}

