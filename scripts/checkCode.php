<?php
	// Checks to see if a security code is set and is correct
	if (!isset($secCode) || $secCode != "32rohfs98ryo3ahnbq7n") {
		die("Unauthorised Access");
	}
?>