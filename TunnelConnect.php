<?php

class TunnelConnect {

    public $connection;
    public $stream;

    public function __construct($remote_host, $remote_port, $remote_user, $remote_pass){

        $this->connection = ssh2_connect($remote_host, $remote_port);
        ssh2_auth_password($this->connection, $remote_user, $remote_pass);

    }

    public function run_on_remote($cmd_sequence){

        $this->stream = ssh2_exec($this->connection, $cmd_sequence);
        stream_set_blocking($this->stream, true);

        return $this->stream;

    }

    public function __destruct(){

        $this->stream = NULL;
        $this->connection = NULL;

    }

}

?>
