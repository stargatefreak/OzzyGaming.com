<?php
	include('Net/SFTP.php');
	$sftp = new Net_SFTP('s3.vm.thrzn.net', '2222');
	if (!$sftp->login('steam', 'OzzyGaming1065')) {
		exit('Login Failed');
	}
?>