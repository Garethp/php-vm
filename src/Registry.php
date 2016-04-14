<?php


namespace phpVm;


class Registry
{
    protected $registry = array(0, 0, 0, 0, 0, 0, 0, 0);

    public function get($index) {
        return $this->registry[$index];
    }

    public function set($index, $value) {
        $this->registry[$index] = $value;
    }
}