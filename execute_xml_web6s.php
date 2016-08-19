<?php
/*
Plugin Name: Execute XML Web6S
Plugin URI: http://web6s.com/
Description: custom plugin for executing autotrader xml feed
Author: Ben Chung
Version: 1
Author URI: http://web6s.com/
*/


register_activation_hook(__FILE__, 'my_activation');
add_action('my_daily_event', 'do_this_daily');

function my_activation() {
	//wp_schedule_event( time(), 'custom_daily', 'my_daily_event');

        // Schedule an action if it's not already scheduled
        if ( ! wp_next_scheduled( 'my_daily_event' ) ) {
            wp_schedule_event( time(), 'custom_daily', 'my_daily_event' );
        }
        
}

function do_this_daily() {
    

    // delete posts
    $mycustomposts = query_posts( 'posts_per_page=100' );
    foreach( $mycustomposts as $mypost ) { 

    wp_delete_post( $mypost->ID, true);
    // Set to False if you want to send them to Trash.
    }
    
// copy autotrader file through FTP----------------------------------------------------------/
//FTP Hostname
    $ftp_server = "ftp1.trader.com";
    $ftp_username = "NiagaraAutoSales";
    $ftp_userpassword = "3Rp87b2";

    //$local_file = "/home1/onepixe3/public_html/niagaraautosales/wp-content/themes/thematicsamplechildtheme/autotraderfeed.xml";
    $local_file = "/home/mollys7/public_html/niagaraautosales.com/wp-content/themes/thematicsamplechildtheme/autotraderfeed.xml";

//This is the name and location on your FTP server
    /*     * *
      note that the starting directory is what would be available when you logged in via an FTP program. This was one thing that caused me a bit of confusion - because I had originally been placing the "full server" path here - but that's not what I see when I FTP in... notice the difference between this path and the "local path" above.
     * * */
    $server_file = "Transformed1925.xml";

//connect to the server
    $conn_id = ftp_connect($ftp_server) or die("I couldn't connect to the ftp server");
//login to the server
    $login_result = ftp_login($conn_id, $ftp_username, $ftp_userpassword);
//get the file!
    if (ftp_get($conn_id, $local_file, $server_file, FTP_ASCII)) {
//ftp_get can get files in ascii or binary,
//binary would have FTP_BINARY instead of FTP_ASCII
        echo "got it!!";
    } else {
        echo "nope";
    }
//close the FTP connection
    ftp_close($conn_id);

// end copy autotrader file through FTP----------------------------------------------------------/
    
    
// post to run script: www.1pixeldesign.com/niagaraautosales/wp-content/themes/thematicsamplechildtheme/autotrader_xml.php    
    function post_to_url($url) {
        $post = curl_init();
        curl_setopt($post, CURLOPT_URL, $url);
        $result = curl_exec($post);
        curl_close($post);
        }
    post_to_url(home_url() . "/wp-content/themes/thematicsamplechildtheme/autotrader_xml.php");
    
    
}

// Add a new interval of a day for fine tuning
// See http://codex.wordpress.org/Plugin_API/Filter_Reference/cron_schedules
add_filter( 'cron_schedules', 'add_daily_cron_schedule' );
function add_daily_cron_schedule( $schedules ) {
    $schedules['custom_daily'] = array(
        'interval' => 86400, // 1 day in seconds
        'display'  => __( 'Once Daily' ),
    );
 
    return $schedules;
}


register_deactivation_hook(__FILE__, 'my_deactivation');

function my_deactivation() {
	wp_clear_scheduled_hook('my_daily_event');
}

//testing------------------------------------------------------
//put these in plugin file or functions.php
function output_test() {
       
}
 add_action('test_hook','output_test');
 //end testing------------------------------------------------------

?>