<?php

class TranslateModel implements IModel {

    public $hasError = false;
    public $errorText = false;
    public $output = "";
    public $dna = "";
    public $mrna = "";
    public $proteins = "";
    public $background;
    public $steel;

    public function __construct(\Steel\Steel $steel) {
        $this->steel = $steel;
    }

}
