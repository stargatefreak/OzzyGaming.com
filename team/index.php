<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<title>OzzyGaming.com Team</title>
	<!-- Fonts  -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300italic,300,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Bitter:400,400italic,700' rel='stylesheet' type='text/css'>
	<!-- CSS -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/fontselect.css" />
	<link rel="stylesheet" type="text/css" href="css/style2.css" title="light-blue" media="screen" />
	<link rel="stylesheet" type="text/css" href="css/header.css" />

	<link rel="stylesheet" href="css/footer-basic-centered.css">
	<link rel="stylesheet" href="css/dropdown.css">
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
	<link href="http://files.enjin.com/768101/links.html" media="screen" type="text" >


</head>
<body>

<div class="body">

<?php
include("header.php");
include("../../scripts/gamedb.php");
$query = $gdb->prepare("SELECT adminname,adminbio,adminlevel,adminimage,adminemail FROM arma3life.admins WHERE adminlevel > 1 and active = '1' order by id asc");
$query->execute();
$result = $query->fetchall(PDO::FETCH_ASSOC);
$ranks = array(1=>"Helpdesk",2=>"Moderator",3=>"Administrator",4=>"Server Admin",5=>"Manager",6=>"Executive",7=>"Founder");
?>
<div class="about-info4">
	<div class="container no-padding">
		<div class="row">
			<div class="col-md-12 no-padding">
				<div>
					<div class="col-md-12 no-padding team-wrap">
						<div class="row">
								<?php
									foreach ($result as $x) {
										
										$rank = $ranks[$x[adminlevel]];
										if ($x[adminlevel] == 5 and $x[adminname] == "Craig"){
											$rank = "Interim Executive";
										}
										
										if ($x[adminbio] != '""'){
											$bio = $x[adminbio];
										} else {
											$bio = "This staff member has not yet made their bio.";
										};//<p>' . $bio . '</p>
										echo '<div class="col-md-3">
																		<div class="staff-wrap">
																			<div class="staff-info">
																			<img width="241" height="241 "src="' . $x[adminimage] . '" alt=""/>

																				<h4>' . $x[adminname] . '<span>' . $rank . '</span></h4>
																				
																				<br><span>' . $x[adminemail] . '</span></h4>
																			</div>
																		</div>
																	</div>';
									};
								?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
		<footer class="footer-basic-centered">

			<p class="footer-company-motto"></p>

			<div class="footer-links">

				<a>Designed and scripted by Ryan</a>

			</div>
			
			<p class="footer-company-name">OzzyGaming &copy; 2016</p>
		</footer>
</body>

</html>