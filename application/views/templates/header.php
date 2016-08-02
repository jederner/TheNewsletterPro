<?php
$commonHeaderIcon = "btn btn-default btn-sm pull-right";
$signoutData = array(
    "title" => "Sign Out",
    "class" => $commonHeaderIcon
);

$dashboardData = array(
    "title" => "Home",
    "class" => $commonHeaderIcon
);

$profileData = array(
    "title" => "Profile",
    "class" => $commonHeaderIcon
);

$reportsData = array(
    "title" => "Reports",
    "class" => $commonHeaderIcon
);

$clientsData = array(
    "title" => "Clients",
    "class" => $commonHeaderIcon
);

$adminData = array(
    "title" => "Admin",
    "class" => $commonHeaderIcon
);

$articleData = array(
    "title" => "Articles",
    "class" => $commonHeaderIcon
);

$categoriesData = array(
    "title" => "Admin",
    "class" => $commonHeaderIcon
);

$wikiData = array(
    "title" => "Wiki",
    "class" => $commonHeaderIcon,
    "target"=> "_blank"
);

?>
<html>
	<head>
		<title><?php echo "$siteTitle - $title";?></title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1"/>
		<link rel='stylesheet' type='text/css' href="<?php echo $assets;?>css/global-min.css"></link>
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/ui-lightness/jquery-ui.css">
		<link rel='stylesheet' href='//cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css'></link>
		<script src="https://use.fontawesome.com/999f14cf27.js"></script>
	</head>
	<body>
		<header>
			<a class="notBtn" href="/index.php/dashboard/view">
				<div id="logo"><span class="ghost"><?php echo $siteTitle; ?></span></div>
			</a>
			<?php
			if(!empty($_SESSION["UserLoggedIn"])) {
			?>
			<div id="signout">
				<div class="btn-group">
					<?php
					echo anchor('Login/signout', '<i class="fa fa-sign-out"></i>', $signoutData);
					if($_SESSION["UserRole"]==="admin") {
						echo anchor('Admin/view', '<i class="fa fa-gears"></i>', $adminData);
					}
					echo anchor('http://wiki.newsletterpro.biz','<i class="fa fa-wikipedia-w"></i>',$wikiData);
                                        echo anchor('Reports/view','<i class="fa fa-bar-chart"></i>',$reportsData);
					echo anchor('profile/details','<i class="fa fa-user"></i>',$profileData);
					echo anchor('Articles/view', '<i class="fa fa-newspaper-o"></i>', $articleData);
					echo anchor('Clients/view', '<i class="fa fa-users"></i>', $clientsData);
					echo anchor('Dashboard/view', '<i class="fa fa-home"></i>', $dashboardData);
					?>
				</div>
				<div class="greeting">Signed in as <?php echo $_SESSION["UserDisplayName"]; ?></div>
			</div>
			<?php
			}
			?> 
		</header>
		<div id='main-container'>
                        <?php if(!isset($noHeader)) {
                        ?>
                        <h1><?php if($title!=='Home') { echo $title; } ?></h1>
                        <?php
                        }
                        
			if(!empty($_SESSION["DisplayMessage"])) {
				echo "<p class='displayMessage'>" . $_SESSION["DisplayMessage"] . "</p>";
				unset($_SESSION["DisplayMessage"]);
			}
			?>