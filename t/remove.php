<?php

function __cleanData($c){
	return preg_replace('/\D,/', '', $c);
}
if( $_GET["eventID"] &&  $_POST["entryID"] && __cleanData($_GET["eventID"]) == $_GET["eventID"] && __cleanData($_POST["entryID"]) == $_POST["entryID"]){
	$output = shell_exec('/var/www/html/tagid/t/php_root '.__cleanData($_GET["eventID"]).' '.__cleanData($_POST["entryID"]));
	echo "<pre>$output</pre>";
}else{
	echo "<pre>:/</pre>";
}

?>