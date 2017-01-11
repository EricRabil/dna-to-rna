<?php

class ErrorView implements IView {

    private $bundle;
    private $model;
    private $context = [];

    public function __construct(\Steel\MVC\MVCBundle $bundle) {
        $this->bundle = $bundle;
        $this->model = $this->bundle->get_model();
    }

    public function render() {
        $this->context['error_title'] = $this->model->get_error_title();
        $this->context['error_text'] = $this->model->get_error_text();
        extract($this->context);
        $page = "error.phtml";
        require $this::TEMPLATESDIR . '/layout.phtml';
    }

}
