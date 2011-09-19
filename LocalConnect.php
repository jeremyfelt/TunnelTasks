<?php

class LocalConnect{

    public $command_output;

    public function __construct(){


    }

    public function run_on_local($cmd_sequence){

        $this->command_output = shell_exec($cmd_sequence);

    }

    public function grab_sql_updates($sql_update_dir){

        /*  Grab all SQL update files and process them against the newly imported DB
            by building a command and running it against $this->run_on_local()  */

    }

    public function __destruct(){

    }

}

?>
