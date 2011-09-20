<?php

/*  Current example 'technically' works. Have noticed once where the entire .sql file didn't transfer from production to staging. */

require ( 'config.php' );
require ( 'TunnelConnect.php' );
require ( 'LocalConnect.php' );
require ( 'CommandBuilder.php' ); /* adds change_directory, move_file, dump_database, import_database */

echo "\n\nAnd go!\n";

/*  Build the file we want to pass back and forth. */
$file_date = date('YmdHi');
$production_mysql_file = $file_date . "_" . $production_mysql_db . ".sql";
$example_sql_file = "db_example_setup.sql";

/*  Build the command that we'll issue on the remote server. */

$remote_command = new CommandBuilder();

$remote_command->change_directory($production_mysql_dir);
$remote_command->dump_database($production_mysql_db, $production_mysql_user, $production_mysql_pass, $production_mysql_file);
$remote_command->change_directory($remote_wp_dir);
$remote_command->create_tarball($file_date . '_wpdir.tar');
$remote_command->move_file($file_date . '_wpdir.tar', $production_mysql_dir);

echo "Remote command sequence built. \n"; /* Feeling some fancy output on the command line for now. */

/*  Build the command that we'll issue on the local server. */

$local_command = new CommandBuilder();

$local_command->import_database($production_mysql_db, $local_mysql_user, $local_mysql_pass, $example_sql_file);
$local_command->change_directory($local_mysql_dir, 1);
$local_command->import_database($production_mysql_db, $production_mysql_user, $production_mysql_pass, $production_mysql_file);
$local_command->move_file($file_date . '_wpdir.tar', $staging_wp_dir);
$local_command->clear_directory($staging_wp_dir);
$local_command->change_directory($staging_wp_dir);
$local_command->extract_tarball($file_date . '_wpdir.tar');

echo "Local command sequence built. \n";

/*  Build the command sequence to run on the remote server after file transfer. */

$remote_post_command = new CommandBuilder();

$remote_post_command->change_directory($remote_wp_dir);
$remote_post_command->remove_file($file_date . '_wpdir.tar');

/*  Open the SSH tunnel to the production server. */

$my_tunnel = new TunnelConnect($production_ssh_ip, $production_ssh_port, $production_ssh_user, $production_ssh_pass);

echo "Tunnel is open...\n";

/*  Run our command sequence on the remote server and grab
    the files that were created. */

$my_tunnel->run_on_remote($remote_command->command_sequence);

echo "Remote command sequence issued.\n";

$my_tunnel->grab_remote_file($production_mysql_dir . $production_mysql_file, $local_mysql_dir . $production_mysql_file);

echo "Remote mysqldump file grabbed. \n";

$my_tunnel->grab_remote_file($production_mysql_dir . $file_date . '_wpdir.tar', $local_mysql_dir . $file_date . '_wpdir.tar');

echo "Remote wordpress tarball grabbed. \n";

$my_tunnel->run_on_remote($remote_post_command->command_sequence);

$my_tunnel = NULL;

echo "Tunnel is closed.\n";
/*  Run our local command sequence to extract the files and
    setup the database. */

$my_local = new LocalConnect();
$my_local->run_on_local($local_command->command_sequence);

echo "Local command sequence issued.\n\n";

?>
