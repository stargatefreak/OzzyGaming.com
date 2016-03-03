<?php
	if (!isset($sec) || $sec !== '123cust') { die(); }
	if (!isset($dbsite)){ require("server/dbsite.php"); }

	$query = $dbsite->prepare("SELECT * FROM navigation ORDER BY itemOrder ASC");
	$query->execute();
	$result = $query->fetchAll(PDO::FETCH_ASSOC);

	$navItems = array();
	$layout = array();
	foreach ($result as $item) {
		$navItems[$item['id']] = $item;
		if ($item['parent'] == -1){
			$layout[$item['id']] = array();
		} else {
			$layout[$item['parent']][$item['id']] = array();
		}
	}

	foreach($layout as $id => $children){
		if (count($children) == 0){
			echo addMenuItem($navItems[$id]['name'], $navItems[$id]['url']);
		} else {
			echo startDropdown($navItems[$id]['name']);
			foreach($children as $id => $child){
				echo addMenuItem($navItems[$id]['name'], $navItems[$id]['url']);
			}
			echo endDropdown();
		}
	}


function startDropdown($name){
	$str = '<li class="dropdown">' . "\n";
	$str .= '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">';
	$str .= $name;
	$str .= '<span class="caret"></span>' . "\n";
	$str .= '</a>' . "\n";
	$str .= '<ul class="dropdown-menu">' . "\n";
	return $str;
}


function endDropdown(){
	$str = '</ul>' . "\n";
	$str .= '</li>' . "\n";
	return $str;
}


function addMenuItem($name, $url){
	$parts = parse_url($_SERVER['REQUEST_URI']);
	$active = '';

	if (strpos($url,'?') !== false){
		if ($parts['query'] == substr($url, strpos($url, '?')+1)){
			$active = ' class="active"';
		}
	}

	return '<li'. $active .'><a href="' . $url .'">' . $name . '</a></li>' . "\n";
}


function checkAllowed($item){
	//group_memberships(false, $user->data['user_id']); //admin group = 5, new users = 7
	// Check access level
	// Check page
	return true;
}


function addhttp($url) {
	if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
	    $url = "http://" . $url;
	}
	return $url;
}
?>