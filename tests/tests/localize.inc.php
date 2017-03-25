<?php
/**
 * Function to localize our site
 * @param $site The Site object
 */
return function(Steampunked\Site $site) {
    // Set the time zone
    date_default_timezone_set('America/Detroit');
    $site->setEmail('mateene@cse.msu.edu');
    $site->setRoot('/~mateene/project2');
    $site->dbConfigure('mysql:host=mysql-user.cse.msu.edu;dbname=mateene',
        'mateene',       // Database user
        'GMJ7VYAp6AP4nU9t',       // Database password
        'testProj2_');            // Table prefix
};