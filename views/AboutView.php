<?php

class AboutView implements IView {

    private $bundle;
    private $model;
    private $context = [];

    public function __construct(\Steel\MVC\MVCBundle $bundle) {
        $this->bundle = $bundle;
        $this->model = $this->bundle->get_model();
    }

    public function render() {
        $page = 'about.phtml';
        require $this::TEMPLATESDIR . '/layout.phtml';
    }

}
