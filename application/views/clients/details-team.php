<?php
$this->load->helper('form');
foreach($details as $detail) {
    $userid                     = $detail["id"];
    $company                    = $detail["company"];
    $fname                      = $detail["fname"];
    $lname                      = $detail["lname"];
    $status                     = $detail["status"];
    $phone                      = $detail["phone"];
    $email                      = $detail["email"];
    $mailing_schedule           = $detail["mailing_schedule"];
    $timezone                   = $detail["timezone"];
    $pm_id                      = $detail["pm_id"];
    $pm_fname                   = $detail["pm_fname"];
    $pm_lname                   = $detail["pm_lname"];
    $package_type               = $detail["package_type"];
    $list_size                  = $detail["list_size"];
    $mail_date                  = $detail["mail_date"];
    $versions                   = $detail["versions"];
    $client_demographics        = $detail["demographics"];
    $project_manager            = $detail["project_manager"];
    $date_sold                  = $detail["date_sold"];
    $date_onboarded             = $detail["date_onboarded"];
    $sale_source                = $detail["sale_source"];
    $pieces_mailed              = $detail["pieces_mailed"];
    $price_per_pieces           = $detail["price_per_pieces"];
    $team                       = $detail["team"];
    $writer                     = $detail["writer"];
    $designer                   = $detail["designer"];
    $total_pages                = $detail["total_pages"];
    $unique_pages               = $detail["unique_pages"];
    $custom_content             = $detail["custom_content"];
    $filler_content             = $detail["filler_content"];
    $client_submitted_content   = $detail["client_submitted_content"];
    $side_campaigns             = $detail["side_campaigns"];
    $return_date                = $detail["return_date"];
    $layout_guide               = $detail["layout_guide"];
}


if(!empty($date_sold)) {
    $date_sold = date("m/d/Y",strtotime($date_sold));
}

if(!empty($return_date)) {
    $return_date = date("m/d/Y",strtotime($return_date));
}

if(!empty($date_onboarded)) {
    $date_onboarded = date("m/d/Y",strtotime($date_onboarded));
}

?>
<h1>
	<?php
	echo "$company - $fname $lname";
	if(!empty($email)) {
		echo "&nbsp;";
		echo "<a href='mailto:$email' class='notBtn'><i class=\"fa fa-envelope\"></i></a>";
		echo "&nbsp;$email";
	}
	if(!empty($phone)) {
		echo "&nbsp;";
		echo "<a href='tel:$phone' class='notBtn'><i class=\"fa fa-phone\"></i></a>";
		echo "&nbsp;$phone";
	}
	if(!empty($status)) {
		echo "&nbsp;";
		switch($status) {
			case "active":
				echo "<span class='active'>Active</span>";
				break;
			case "inactive":
				echo "<span class='inactive'>Inactive</span>";
				break;
			case "on hold":
				echo "<span class='inactive'>On Hold</span>";
			default:
				echo "";
				break;
		}
	}
	?>
</h1>
<?php if(!empty($return_date)) { echo "<p>Returns $return_date</p>";} ?>
<?php
if(count($secondaryContacts)>0) {
    foreach($secondaryContacts as $info) {
        $fname = $info["first_name"];
        $lname = $info["last_name"];
        $phone = $info["phone"];
        $email = $info["email"];
        echo "<div class='secondaryContact'>
            <strong>$fname $lname</strong><br />";
        if(!empty($phone)) {
            echo "<a class='notBtn' href='tel:$phone'><i class=\"fa fa-phone\"></i></a> $phone<br />";
        }
        if(!empty($email)) {
            echo "<a class='notBtn' href='mailto:$email'><i class=\"fa fa-envelope\"></i></a> $email";
        }
            
        echo "</div>";
    }                
}

$addSecondaryData = array(
    "class"=>"notBtn",
    "title"=>"Add secondary contact",
    "id"=>"openSecondaryContactModal"
);

echo "<div class='secondaryContact noLine'>" . anchor("#","<i class=\"fa fa-5x fa-plus-circle\"></i>",$addSecondaryData) . "</div>";
echo "<div class='clearfix'></div>";
?>
<div id="addSecondaryForm" style="display:none;">
    <input type="hidden" name="user_id" id="user_id" value="<?php echo $userid; ?>" />
    <table cellpadding="3" cellspacing="0">
        <tr>
            <td>First Name</td>
            <td><input type='text' name='first_name' id='first_name' /></td>
        </tr>
        <tr>
            <td>Last Name</td>
            <td><input type='text' name='last_name' id='last_name' /></td>
        </tr>
        <tr>
            <td>Phone</td>
            <td><input type='text' name='phone' id='phone' /></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><input type='text' name='email' id='email' /></td>
        </tr>
    </table>
</div>
<div class="tabs">
	<ul>
		<li><a href="#tabs-2">General</a></li>
		<li><a href="#tabs-3">Articles (<?php echo $articlesCount; ?>)</a></li>
		<?php if($_SESSION["UserRole"]==="admin"): ?>
		<li><a href="#tabs-admin">Admin</a></li>
		<?php endif; ?>
	</ul>
	<div id="tabs-2">
		<div id="clientDetailTableHolder">
            <table class="tblClientDetails left" cellpadding="3" cellspacing="0">
                    <tr>
                            <td><u>Mail Date</u></td>
                            <td>
                                    <?php echo $mail_date; ?>
                            </td>
                    </tr>
                    <tr>
                            <td><u>Mailing Schedule</u></td>
                            <td>
                                    <?php echo $mailing_schedule; ?>
                            </td>
                    </tr>
                    <tr>
                            <td><u>Package Type</u></td>
                            <td><?php echo $package_type; ?></td>
                    </tr>
                    <tr>
                            <td><u>List Size</u></td>
                            <td><?php echo $list_size; ?></td>
                    </tr>
                    <tr>
                            <td><u>Versions</u></td>
                            <td><?php echo $versions; ?></td>
                    </tr>
                    <tr>
                            <td><u>Demographics</u></td>
                            <td>
                                    <?php echo $demographicsLabel; ?>
                            </td>
                    </tr>
                    <tr>
                            <td><u>Side Campaigns</u></td>
                            <td><?php echo $side_campaigns; ?></td>
                    </tr>
            </table>
            <table class="tblClientDetails left" cellpadding="3" cellspacing="0">
                    <tr>
                            <td><u>Date Sold</u></td>
                            <td><?php echo $date_sold; ?></td>
                    </tr>
                    <tr>
                            <td><u>Date Onboarded</u></td>
                            <td><?php echo $date_onboarded; ?></td>
                    </tr>
                    <tr>
                            <td><u>Sale Source</u></td>
                            <td><?php echo $sale_source; ?></td>
                    </tr>
                    <tr>
                            <td><u>Price Per Pieces</u></td>
                            <td><?php echo $price_per_pieces; ?></td>
                    </tr>
            </table>
            <table class="tblClientDetails left" cellpadding="3" cellspacing="0">
                    <tr>
                            <td><u>Project Manager</u></td>
                            <td>
                                    <?php echo $teamInfo["pm"]; ?>
                            </td>
                    </tr>
                    <tr>
                            <td><u>Team</u></td>
                            <td>
                                    <?php echo $teamName; ?>
                            </td>
                    </tr>
                    <tr>
                            <td><u>Writer</u></td>
                            <td>
                                    <?php echo $teamInfo["writer"]; ?>
                            </td>
                    </tr>
                    <tr>
                            <td><u>Designer</u></td>
                            <td>
                                    <?php echo $teamInfo["designer"]; ?>
                            </td>
                    </tr>
            </table>
            <div class='clearfix'></div>
        </div>
	</div>
	<div id="tabs-3">
		<h2>Currently Assigned Articles</h2>
		<?php
		echo anchor("Clients/assignArticles/$userid", 'Assign Article');

		if(count($articles)>0) {
		?>
			<table id="tblClientArticles" class="dataTable" cellpadding="3" cellspacing="0">
				<thead>
					<tr>
						<th>Name</th>
						<th>Type</th>
						<th>Edition</th>
						<th>Demographic</th>
						<?php 
						if(($_SESSION["UserID"]===$pm_id) || ($_SESSION["UserRole"]==="admin")) {
							echo "<th></th>";
							echo "<th></th>";
						}
						?>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach($articles as $article) {
						$user 			= $article["uid"];
						$id 			= $article["article_id"];
						$name 			= $article["article_name"];
						$category		= $article["category"];
						$path 			= $article["article_path"];
						$demographic 	= $article["article_demographic"];
						$description	= $article["article_description"];
						if(!empty($demographic)) {
							$demographic = implode(", ",$demographic);
						}
						$keywords 		= $article["article_keywords"];
						$edition		= date("M, Y", strtotime($article["edition"]));
						echo "
						<tr>
							<td>" . anchor("Articles/details/$id",$name,"class='notBtn' title=\"$description\"") . "</td>
							<td>$category</td>
							<td>$edition</td>
							<td>$demographic</td>";
						if(($_SESSION["UserID"]===$pm_id) || ($_SESSION["UserRole"]==="admin")) {
							$articleData = array(
											"class"=>"clientsUnassign"
										);
							echo "<td>" . anchor("Clients/unassignArticle/$user/$id", 'Permaremove', $articleData) . "</td>";
							echo "<td>" . anchor("Clients/unassignArticle/$user/$id/1", 'Unassign', $articleData) . "</td>";
						}
						echo "
						</tr>";
					}
					?>
				</tbody>
			</table>
			<div id="dialog-confirm" class='ghost' title="Unassign article?">
				<p>
					<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
					Are you sure you wish to continue?
				</p>
			</div>
		<?php
		}
		else {
			echo "<p>This client has no assigned articles.</p>";
		}
		?>
                <table class="tblClientDetails" cellpadding="3" cellspacing="0">
			<tr>
				<td><u>Total Pages</u></td>
				<td><?php echo $total_pages; ?></td>
			</tr>
			<tr>
				<td><u>Unique Pages</u></td>
				<td><?php echo $unique_pages; ?></td>
			</tr>
			<tr>
				<td><u>Custom Content</u></td>
				<td><?php echo $custom_content; ?></td>
			</tr>
			<tr>
				<td><u>Filler Content</u></td>
				<td><?php echo $filler_content; ?></td>
			</tr>
			<tr>
				<td><u>Client Submitted Content</u></td>
				<td><?php echo $client_submitted_content; ?></td>
			</tr>
			<tr>
				<td><u>Layout Guide</u></td>
				<td><?php echo $layout_guide; ?></td>
			</tr>
		</table>
	</div>
	<?php if($_SESSION["UserRole"]==="admin"): ?>
	<div id="tabs-admin">
		<?php echo anchor("clients/delete/$userid","Delete client","class='hrefConfirm'"); ?>
	</div>
	<?php endif; ?>
</div>
<Br />
<h1>Notes</h1>
<?php if(count($notes)===0): ?>
<p>No special notes have been added for this client.</p>
<?php else :?>
<table class="tblClientDetails" cellpadding="3" cellspacing="0">
    <thead>
        <tr>
            <th>Entered</th>
            <th>Entered By</th>
            <th>Note</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach($notes as $note) {
            $entered = date_create($note["entered"]);
            $entered = date_format($entered,"m/d/Y H:i:s");
            $content = $note["content"];
            $myuser  = $note["username"];
            echo "<tr>"
            . "     <td>$entered</td>"
                . "<td>$myuser</td>"
                    . "<td>$content</td>"
                    . "</tr>";
        }
        ?>
    </tbody>
</table>
<?php endif; ?>