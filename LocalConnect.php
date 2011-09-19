<?php

class LocalConnect{

    public $command_output;

    public function __construct(){


    }

    public function run_on_local($cmd_sequence){

        $this->command_output = shell_exec($cmd_sequence);

    }

    public function __destruct(){

    }

}

?>
