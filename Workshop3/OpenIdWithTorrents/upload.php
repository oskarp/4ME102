<?php
require( dirname(__FILE__) . '/lib/PHPTracker/Autoloader.php' );
PHPTracker_Autoloader::register();

// To make filename safe
// From php.net

$SafeFile = $HTTP_POST_FILES['ufile']['name'];
$SafeFile = str_replace("#", "No.", $SafeFile);
$SafeFile = str_replace("$", "Dollar", $SafeFile);
$SafeFile = str_replace("%", "Percent", $SafeFile);
$SafeFile = str_replace("^", "", $SafeFile);
$SafeFile = str_replace("&", "and", $SafeFile);
$SafeFile = str_replace("*", "", $SafeFile);
$SafeFile = str_replace("?", "", $SafeFile);

// And we are uploading it to
$uploaddir = "files/";
$path = $uploaddir . $SafeFile;



if ($ufile != none) { //As long as a file was selected... 
    if (copy($HTTP_POST_FILES['ufile']['tmp_name'], $path)) { //If it has been copied... 
        //GET FILE NAME 
        $theFileName = $HTTP_POST_FILES['ufile']['name'];
        //GET FILE SIZE 
        $theFileSize = $HTTP_POST_FILES['ufile']['size'];

        $config = new PHPTracker_Config_Simple(array(
                    // Persistense object implementing PHPTracker_Persistence_Interface.
                    // We use MySQL here. The object is initialized with its own config.
                    'persistence' => new PHPTracker_Persistence_Mysql(
                            new PHPTracker_Config_Simple(array(
                                'db_host' => 'localhost',
                                'db_user' => 'your user',
                                'db_password' => 'your password',
                                'db_name' => 'your database name ',
                            ))
                    ),
                    // List of public announce URLs on your server.
                    'announce' => array(
                        'THEURLOFYOURANNOUNCEFILE',
                    ),
                ));
        // Instantiate a new PHP tracker
        $core = new PHPTracker_Core($config);
        // 
        $filetowrite = "torrents/" . time() . $theFileName . ".torrent";
        $file = fopen($filetowrite, 'w');
        fwrite($file, $core->createTorrent("files/".$theFileName, $theFileSize));
        fclose($file);

        echo "Created torrent with " . $theFileName . " and  the size " . $theFileSize;
    }
}
?>
