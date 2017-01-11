<?php

class AboutModel implements IModel {

    public $steel;

    public function __construct(\Steel\Steel $steel) {
        $this->steel = $steel;
    }

}
