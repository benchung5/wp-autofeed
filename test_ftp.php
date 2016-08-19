<?php

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
?>
