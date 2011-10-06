<?php

session_start();
require( dirname(__FILE__) . '/lib/PHPTracker/Autoloader.php' );
require( dirname(__FILE__) . '/lib/openid/openid.php');
PHPTracker_Autoloader::register();
$html = "<html><head><link href='style.css' rel='stylesheet' type='text/css'></head><body>";
try {
    // If we have a session, create the object from the session
    if ($_SESSION['openid']) {
        $openid = unserialize($_SESSION['openid']);
    }
    // Otherwise we need to create a new one
    else {
        $openid = new LightOpenID('dellserv.msi.vxu.se');
    }
    if (!$openid->mode) {
        if (isset($_GET['login'])) {
            // 
            $openid->identity = 'https://www.google.com/accounts/o8/id';
            $openid->required = array('namePerson/first', 'namePerson/last', 'contact/email');
            header('Location: ' . $openid->authUrl());
        }
        $html .= "<h1>The torrent thing</h1>";
        $html .= "<form action='?login' method='post'>";
        $html .= " <button>Login with Google</button>";
        $html .= "</form></body></html>";
    } elseif ($openid->mode == 'cancel') {
        echo 'Log in was canceled';
    } elseif (isset($_GET['logout'])) {
        session_destroy();
        header('Location: index.php');
    } else {
        $attrib = $openid->getAttributes();
        
        $html .= 'Logged in as ' . $attrib['namePerson/first'] . " " . $attrib['namePerson/last'] . '  <a href="information.php">more information</a> <a href="index.php?logout">logout</a>';
        $html .= "<h1>Upload a new file</h1>";
        $html .= "<form action='upload.php' method='post' enctype='multipart/form-data'><input type='file'  name='ufile' /><input type='submit' value='Upload' /></form>";
        $html .= "<h1>Available torrents</h1>";

        $torrents = scandir("torrents");
        $torrents = array_slice($torrents, 2);
        foreach ($torrents as $torrent) {
            $html .= "<a href='torrents/" . $torrent . "'>" . $torrent . "</a><br />";
        }
        $_SESSION['openid'] = serialize($openid);
    }
} catch (ErrorException $e) {
    echo $e->getMessage();
}
// Output html to page
echo $html;