<?php

class Storymarket_Links_LinkedResource extends Storymarket_Base_Resource {
    protected function _add_details($info) {
        $this->_info['links'] = array();
        foreach ($info as $key => $value) {
            if ($key != 'links') {
                continue;
            }

            unset($info[$key]);
            foreach ($value as $link) {
                $this->_info['links'][$link['rel']] = new Storymarket_Links_Link(
                    $link['rel'],
                    $link['href'],
                    $link['allowed_methods']
                );
            }
        }
        parent::_add_details($info);
    }
}

