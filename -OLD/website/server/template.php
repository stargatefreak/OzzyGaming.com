<!DOCTYPE html>
<html>
	<head>
		<title>
			<?php
				if (isset($tvar['titleAppend']) && $tvar['titleAppend'] == "prefix") { echo "OzzyGaming"; }
				echo (isset($tvar['title']) && $tvar['title'] != "" && isset($tvar['titleAppend']) && $tvar['titleAppend'] == "prefix") ? " - " : "";
				echo (isset($tvar['title']) && $tvar['title'] != "") ? $tvar['title'] : "";
				echo (isset($tvar['title']) && $tvar['title'] != "" && isset($tvar['titleAppend']) && $tvar['titleAppend'] == "postfix") ? " - " : "";
				if (isset($tvar['titleAppend']) && $tvar['titleAppend'] == "postfix") { echo "OzzyGaming"; }
			?>
		</title>


		<?php
			$theme = "dark";
			if (isset($_COOKIE['siteTheme']) && in_array($_COOKIE['siteTheme'], $tvar['themes'])){
				$theme = $_COOKIE['siteTheme'];
			}
		?>
		<!-- Bootstrap & Theme coloring -->
		<link rel="stylesheet" href="css/bootstrap.<?php echo $theme; ?>.css" />
		<link rel="stylesheet" href="css/theme.<?php echo $theme; ?>.css" />

			<!-- Main stylesheet -->
			<link rel="stylesheet" href="css/main.css" />
		<?php
			if ($tvar['page'] == "home") {
		?>
			<!-- Homepage Stylesheet (1 column) -->
			<link rel="stylesheet" href="css/home.css" />
			<link rel="stylesheet" href="css/col.css" />
		<?php
			} else {
		?>
			<!-- General Page Stylesheet (2-column) -->
		<?php } ?>

		<?php
			foreach ($tvar['cssSheets'] as $value) {
				echo '<link rel="stylesheet" href="css/'.$value.'" />';
			}

			echo "<style>" . $tvar['css'] . "</style>";
		?>

	</head>
	<body>

		<header>
			<nav class="navbar navbar-default navbar-fixed-top">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
							<span class="sr-only">Toggle navigation</span>
				            <span class="icon-bar"></span>
				            <span class="icon-bar"></span>
				            <span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="?">OzzyGaming</a>
					</div>

					<div id="navbar" class="navbar-collapse collapse">
						<ul class="nav navbar-nav">
							<?php require("server/navbar.php"); ?>
						</ul>

						<ul class="nav navbar-nav navbar-right">
							<?php
								if ($user->data['user_id'] == 1 || !$user->data['is_registered']){
							?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
									Log In<span class="caret"></span>
								</a>
								<div class="dropdown-menu" style="padding: 20px; ">
									<form action="forums/ucp.php?mode=login" method="POST">
										<label for="usernameTop">Username:</label> <input type="text" id="usernameTop" name="username"><br />
										<label for="passwordTop">Password:</label> <input type="password" id="passwordTop" name="password" /><br />
										<input type="hidden" name="redirect" value="../">
										<input type="checkbox" name="autologin" id="autologinTop"> <label for="autologinTop">Remember me?</label><br />
										<input type="submit" value="Log In" name="login" style="margin: 5px 0; width: 100%;"/><br />
										<a href="">Lost your password?</a><br />
										<a href="">Not a member? Register!</a>
									</form>
								</div>
							</li>
							<?php
								} else {
							?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
									<?php echo ucfirst($user->data['username']); ?><span class="caret"></span>
								</a>
								<ul class="dropdown-menu">
									<li><a href="forums/memberlist.php?mode=viewprofile&u=<?php echo $user->data['user_id']; ?>">View My Profile</a></li>
									<li><a href="forums/ucp.php?i=pm&folder=inbox">View Messages <span class="badge"><?php echo $user->data['user_unread_privmsg']; ?> new</span></a></li>
									<li><a href="?page=logout&redir=<?php echo $_SERVER['REQUEST_URI'];?>">Log Out</a></li>
								</ul>
							</li>
							<?php } ?>

							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
									<span class="glyphicon glyphicon-list-alt" style="line-height: 20px;"></span><span class="caret"></span>
								</a>
								<ul class="dropdown-menu themeMenu">
									<?php
										$t = isset($_COOKIE['siteTheme']) && in_array($_COOKIE['siteTheme'], $tvar['themes']) ? $_COOKIE['siteTheme'] : "dark";
										echo '<li class="dropdown-header">Current theme: '.ucfirst($t).'</li>';
										foreach ($tvar['themes'] as $value) {
											echo '<li><a onclick="toggleTheme(\''.$value.'\')">Change Site Theme ('.ucfirst($value).')</a></li>';
										}
									?>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</header>

		<div id="wrapper">
			<?php
				if ($tvar['success'] == "200"){
					// Page stuff
					echo $tvar['content'];
				} else {
					include("err/" . $tvar['success'] . ".php");
				}
				
				echo "\n\n\n<br/><br/><br/><br/><br/><br/>";
				print_r(group_memberships(false, $user->data['user_id']));
			?>
		</div>

		<!-- Modal for alert popups -->
		<div class="modal fade" id="modalAlert">
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title"></h4>
		      </div>
		      <div class="modal-body">
		        <p></p>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<footer id="footer">
			<div class="socialmedia">
				<?php
					
				?>
			</div>

			<div class="container">
				<p><?php
					if (isset($tvar['footer']) && $tvar['footer'] != ""){
						echo $tvar['footer'];
					} else {
						echo "Copyright &copy; " . $_SERVER['HTTP_HOST'] . " 2015. All rights reserved.";
					}
				?></p>
			</div>
		</footer>

		<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
		<script src="js/jquery-ui.min.js" type="text/javascript"></script>
		<script src="js/bootstrap.min.js" type="text/javascript"></script>
		<script type="text/javascript">
			function toggleTheme(theme){
				theme = typeof theme !== 'undefined' ? theme : "dark";

			    var themes = <?php echo json_encode($tvar['themes']); ?>;

			    if (themes.indexOf(theme)){
			    	document.cookie = "siteTheme=" + theme;
			    } else {
			    	document.cookie = "siteTheme=dark";
			    }
				window.location.reload(false);
			}
		</script>
		<?php
			foreach ($tvar['jsFiles'] as $value) {
				echo '<script src="js/'.$value.'" type="text/javascript"></script>';
			}

			echo "<script type=\"text/javascript\">" . $tvar['js'] . "</script>";
		?>
	</body>
</html>