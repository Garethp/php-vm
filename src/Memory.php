<?php


namespace phpVm;


class Memory
{
    public $memory = array(9,32768,32769,4,19,32768);
    protected $pointer = 0;

    public function read() {
        $value = $this->memory[$this->pointer];
        $this->pointer++;

        return $value;
    }

    public  function getPointer() {
        return $this->pointer;
    }

    public function setPointer($pointer) {
        $this->pointer = $pointer;
    }

    public function loadFromFile($fileName) {
        $this->memory = array();
        $this->pointer = 0;

        $handler = fopen($fileName, "rb");
        while ($data = fread($handler, 2)) {
            $this->memory[] = unpack("v", $data)[1];
        }
        fclose($handler);
    }

    public function EOM() {
        return $this->pointer >= count($this->memory);
    }
}