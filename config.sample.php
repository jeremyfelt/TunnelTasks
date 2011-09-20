<?php

    /* Config for server credentials */

    $production_ssh_ip = NULL;
    $production_ssh_user = NULL; 
    $production_ssh_pass = NULL;
    $production_ssh_port = 22;

    /*  These are example values that match the sample sql file included. */

    $production_mysql_db = "coolblogdb";
    $production_mysql_user = "coolblogdb_user";
    $production_mysql_pass = "coolblogdb_pass";
    $production_mysql_dir = "/tmp/";    /*  Maybe not name to use */

    $local_mysql_user = NULL;
    $local_mysql_pass = NULL;
    $local_mysql_dir = "tmp/";
    $local_script_dir = NULL;

    $remote_wp_dir = "/var/www/wordpress/";
    $staging_wp_dir = NULL;

    /*  Probably a better way to do this, but just in case. Who knows
        what would happen without trailing slashes on the directories.  */

    if(substr($local_mysql_dir,-1) != "/"){

        $local_mysql_dir .= "/";

    }

    if(substr($production_mysql_dir, -1) != "/"){

        $production_mysql_dir .= "/";

    }

    if(substr($remote_wp_dir, -1) != "/"){

        $remote_wp_dir .= "/";

    }

    if(substr($staging_wp_dir, -1) != "/"){

        $staging_wp_dir .= "/";

    }

?>
