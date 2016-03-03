<?php
	SESSION_START();

	// Relevant Includes
	require("server/dbsite.php");

	// PHPBB3 Intergration stuff
	define('IN_PHPBB',true);
	$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : __DIR__ . '/forums/';
	$phpEx = "php";
	include($phpbb_root_path . 'common.' . $phpEx); // Main user stuff
	include($phpbb_root_path . 'includes/functions_user.' . $phpEx);

	// PHPBB3 Session Management
	$user->session_begin();
	$auth->acl($user->data);
	$user->setup();

	// Enable this so we can access $_SERVER etc
	$request->enable_super_globals();
	//group_memberships(false, $user->data['user_id']); //admin group = 5, new users = 7

	// Template values
	$tvar = array(
			// Page name (used in links)
			"page" => "",
			// Title Options
			"title" => "",
			"titleAppend" => "postfix", // false, prefix, postfix
			// CSS Options
			"cssSheets" => array(),
			"css" => "", // In-File CSS
			"themes" => array("dark", "blue", "light", "white"), // Default CSS themes (eg. bootstrap.THEME.css or main.THEME.css)
			// Javascript Options
			"jsFiles" => array(),
			"js" => "", // In-File JS
			// Footer Options
			"footer" => "", // Footer Text
			// Page Content
			"success" => "200",
			"content" => "",
		);


	// Page handling
	if (!isset($_GET['page']) || $_GET['page'] == "home" || $_GET['page'] == "index"){
		// Homepage
		$query = $dbsite->prepare("SELECT * FROM `pages` WHERE `id` = (SELECT `value` FROM `site_settings` WHERE `option` = 'homepage') LIMIT 1");
		$query->execute();
		$result = $query->fetch(PDO::FETCH_ASSOC);
		if (count($result) == 0 || $result == false){
			// Default
			echo "Welcome! This is a default page.";
		} else {
			// Homepage
			$tvar['page'] = $result['name'];
			$tvar['title'] = $result['title'];
			$tvar['content'] = $result['content'];
			// add CSS and JS stuff
			$tvar[''] = $result[''];
		}
	} else {
		// Other Pages
		$query = $dbsite->prepare("SELECT * FROM `pages` WHERE `name` = :name LIMIT 1");
		$query->bindValue(":name", $_GET['page']);
		$query->execute();
		$result = $query->fetch(PDO::FETCH_ASSOC);
		if (count($result) == 0 || $result == false){
			//404
			header($_SERVER['SERVER_PROTOCOL'] . " 404 Not Found");
			$tvar['success'] = "404";
			$tvar['content'] = "";
		} else {
			//Page
			// Check for access allowed. if not return 403 error
			echo "Page found";
			var_dump($result);
		}
	}


	// Pull our template in
	$sec = '123cust';
	require_once('server/template.php');
?>