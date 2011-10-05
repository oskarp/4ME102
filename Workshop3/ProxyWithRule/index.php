<? 
// Starting a session to hold our provider parameter
session_start();
// If you are authenticated trough Google you should not be able to access Facebook
$_SESSION['provider'] = "Google";

?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        
        <p><? echo "You are authenticated from " . $_SESSION['provider']. ": "; ?> try to access <a href="ba-simple-proxy.php?url=http://www.facebook.com&mode=native">facebook</a> </p>
    </body>
</html>
