<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
      
    </head>
    <body>
        <div class="twitter_container">
<?php


require_once('flickr.php'); 
$Flickr = new Flickr; 
$data = $Flickr->search('Europena universities'); 
foreach($data['photos']['photo'] as $photo) { 
	// the image URL becomes somthing like 
	// http://farm{farm-id}.static.flickr.com/{server-id}/{id}_{secret}.jpg  
	echo '<img src="http://farm' . $photo["farm"] . '.static.flickr.com/' . $photo["server"] . '/' . $photo["id"] . '_' . $photo["secret"] . '.jpg">'; 
}
?>
<div>
    </body>
</html>
