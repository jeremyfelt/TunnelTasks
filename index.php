<?php

/*  Current example 'technically' works. */

require ( 'config.php' );
require ( 'TunnelConnect.php' );
require ( 'LocalConnect.php' );

/*  Build the file we want to pass back and forth. */
$file_date = date('YmdHi');
$production_mysql_file = $file_date . "_" . $production_mysql_db . ".sql";

/*  Build the command that we'll issue on the remote server. */

$remote_command = 'cd ' . $production_mysql_dir . ';'
                        . 'mysqldump -u ' . $production_mysql_user . ' -p' . $production_mysql_pass
                        . ' ' . $production_mysql_db . ' > ' . $production_mysql_dir . $production_mysql_file . ';';

$local_command = 'cd ' . $local_mysql_dir . ';'
                . 'mysql -u ' . $local_mysql_user . ' -p' . $local_mysql_pass
                . ' ' . $production_mysql_db . ' < ' . $production_mysql_file . ';'
                . 'mysql -u ' . $local_mysql_user . ' -p' . $local_mysql_pass
                . ' ' . $production_mysql_db . ' < test_inserts.sql';

$my_tunnel = new TunnelConnect($production_ssh_ip, $production_ssh_port, $production_ssh_user, $production_ssh_pass);

$my_tunnel->run_on_remote($remote_command);
$my_tunnel->grab_remote_file($production_mysql_dir . $production_mysql_file, $local_mysql_dir . $production_mysql_file);
$my_tunnel = NULL;

$my_local = new LocalConnect();
$my_local->run_on_local($local_command);


?>
