<?php

namespace Core;

Class container{
    protected $bindings =[];

    public function bind($key, $resolver){

        $this->bindings[$key] = $resolver;
        
    }

    public function resolve($key){
        if(! array_key_exists($key, $this->bindings)){
            throw new \Exception('ไม่เจอ : ' . $key);
        }

        if(array_key_exists($key, $this->bindings)){
            $resolver = $this->bindings[$key];

            return call_user_func($resolver);
        }
    }
}