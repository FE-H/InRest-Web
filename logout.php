<?php
	session_start();

	echo "Redirecting to <a href='index.php'>Login page</a>...";

	session_unset();
	session_destroy();

	echo "<meta http-equiv='refresh' content='3;URL=index.php'>";
?>