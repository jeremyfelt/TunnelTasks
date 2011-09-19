<?php

class TunnelConnect {

    public $remote_host;
    public $remote_port;
    public $remote_user;
    public $remote_pass;
    public $connection;
    public $stream;
    
    public function __construct($host, $port, $user, $pass){

        $this->remote_host = $host;
        $this->remote_port = $port;
        $this->remote_user = $user;
        $this->remote_pass = $pass;
        
        $this->open_remote_tunnel();

    }

    public function open_remote_tunnel(){

        $this->connection = NULL;
        $this->connection = ssh2_connect($this->remote_host, $this->remote_port);
        ssh2_auth_password($this->connection, $this->remote_user, $this->remote_pass);

    }

    public function run_on_remote($cmd_sequence){

        $this->stream = ssh2_exec($this->connection, $cmd_sequence);
        stream_set_blocking($this->stream, true);

        return $this->stream;

    }

    public function grab_remote_file($remote_file_location, $local_file_location){

        $this->open_remote_tunnel();
        ssh2_scp_recv($this->connection, $remote_file_location, $local_file_location);

    }

    public function __destruct(){

        $this->stream = NULL;
        $this->connection = NULL;

    }

}

?>
