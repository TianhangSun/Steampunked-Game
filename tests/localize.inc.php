<?php
/**
 * Function to localize our site
 * @param $site The Site object
 */
return function(Steampunked\Site $site) {
    // Set the time zone
    date_default_timezone_set('America/Detroit');
    $site->setEmail('suntianh@cse.msu.edu');
    $site->setRoot('/~suntianh/project2');
    $site->dbConfigure('mysql:host=mysql-user.cse.msu.edu;dbname=suntianh',
        'suntianh',       // Database user
        'cse477',       // Database password
        'testProj2_');            // Table prefix
};