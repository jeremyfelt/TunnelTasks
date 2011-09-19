<?php

class CommandBuilder {

    public $command_sequence;

    public function __construct(){

        $this->command_sequence = '';

    }

    public function change_directory($new_directory){

        $this->command_sequence .= 'cd ' . $new_directory . ';';

    }

    public function move_file($file_name, $new_directory){

        $this->command_sequence .= 'mv ' . $file_name . ' ' . $new_directory . ';';

    }

    public function dump_database($db_name, $db_user, $db_pass, $db_file){

        $this->command_sequence .= 'mysqldump -u ' . $db_user . ' -p' . $db_pass
                                . ' ' . $db_name . ' > ' . $db_file . ';';

    }

    public function import_database($db_name, $db_user, $db_pass, $db_file){

        $this->command_sequence .= 'mysql -u ' . $db_user . ' -p'. $db_pass
                                . ' ' . $db_name . ' < ' . $db_file . ';';

    }

    public function create_tarball($file_name){

        $this->command_sequence .= 'tar --create --file=' . $file_name . ' *;';

    }

    public function extract_tarball($file_name){
        
        $this->command_sequence .= 'tar -xvf ' . $file_name . ';';

    }

    public function __destruct(){

        $this->command_sequence = NULL;

    }

}
