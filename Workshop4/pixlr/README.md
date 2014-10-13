# Instructions

These example does not work when executed from localhost. Find out what external ip you have and run it from that IP or put it on a real server somewhere.

## Make folders writeable for the web server

In order to be able to save the image that comes back from Pixlr, you need to make the img folder writeable for your web server. 

### OS X

* Find out where on the filesystem your scripts are located. In my case the folder is located at 
`        /Applications/MAMP/htdocs/pixlr/src/img`
* Open a terminal and type 
` sudo chmod -R 777 /the/location/of/your/files/on/the/webserver`
In my case this comes out as
`sudo chmod -R 777 /Applications/MAMP/htdocs/pixlr/src/img`

### Windows
See http://support2.microsoft.com/kb/308419/en-us 