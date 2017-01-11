<?php

class TranslateView implements IView {

    private $bundle;
    private $model;
    private $context = [];

    public function __construct(\Steel\MVC\MVCBundle $bundle) {
        $this->bundle = $bundle;
        $this->model = $this->bundle->get_model();
    }

    public function render() {
        $page = 'index.phtml';
        $this->context['translated'] = true;
        if($this->model->hasError){
          $this->context['error'] = true;
          $this->context['errorText'] = $this->model->errorText;
        }else{
          $this->context['error'] = false;
        }
        $this->context['output'] = $this->model->output;
        $this->context['dna'] = htmlspecialchars($this->model->dna);
        $this->context['mrna'] = htmlspecialchars($this->model->mrna);
        $this->context['proteins'] = $this->model->proteins;
        extract($this->context);
        require $this::TEMPLATESDIR . '/layout.phtml';
    }

}
