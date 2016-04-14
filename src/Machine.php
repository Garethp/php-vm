<?php


namespace phpVm;


class Machine
{
    protected $memory;
    protected $registry;
    protected $intLimit = 32768;
    protected $halted = false;

    public function __construct()
    {
        $this->memory = new Memory();
        $this->registry = new Registry();
    }

    protected function shouldRun() {
        return !$this->memory->EOM() && !$this->halted;
    }

    public function run() {
        $this->memory->loadFromFile("../challenge.bin");

        while($this->shouldRun()) {
            $operation = $this->memory->read();
            $this->doOp($operation);
        }
    }

    public function doOp($operation) {
        switch ($operation) {
            case 6:
                $this->jump();
                break;
            case 9:
                $this->add();
                break;
            case 19:
                $this->printChar();
                break;
            case 21:
                $this->noop();
                break;
            default:
                echo "Do not understand operation $operation";
                exit();
        }
    }

    protected function jump() {
        $pointer = $this->memory->read();
        $this->memory->setPointer($pointer);
    }

    protected function jt() {
        $a = $this->getValue($this->memory->read());
        $pointer = $this->memory->read();
    }

    protected function add() {
        $registryIndex = $this->memory->read();
        $a = $this->getValue($this->memory->read());
        $b = $this->getValue($this->memory->read());

        $c = ($a + $b) % $this->intLimit;
        $this->setToReg($registryIndex, $c);
    }

    protected function printChar() {
        $char = $this->getValue($this->memory->read());
        echo chr($char);
    }

    protected function noop() {

    }

    protected function getValue($value) {
        if ($value < $this->intLimit) {
            return $value;
        }

        $index = $value % $this->intLimit;
        return $this->registry->get($index);
    }

    protected function setToReg($index, $value) {
        $index = $index % $this->intLimit;

        $this->registry->set($index, $value);
    }
}