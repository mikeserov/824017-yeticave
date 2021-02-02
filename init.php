<?php
$link = mysqli_connect("localhost", "root", "root", "yeti_cave");
if (!$link) {
	exit(show_connection_error());
} else {
	if (! mysqli_set_charset($link, "utf8")) {
		exit(show_error());
	}
} 
?>