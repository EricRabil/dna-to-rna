<?php
namespace MyCoolApplicationNamespace;

class MyCoolApplication implements \Steel\IApplication{
    
    private $steel;
    private $bundle;
    private $args;
    
    private $intercepted_classes = array(
        'index'
    );
    
    public function __constructor(\Steel\Steel $steel) {
        $this->steel = $steel;
    }

    public function call(\Steel\MVC\MVCBundle $bundle, $arguments) {
        if(in_array($arguments[0], $this->intercepted_classes)){
            $this->bundle = $bundle;
            $this->args = $arguments;
            return true;
        }else{
            return false;
        }
    }
    
    public function intercepts($classname){
        return in_array($classname, $intercepted_classes);
    }

}