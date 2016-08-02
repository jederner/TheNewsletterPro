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

// Form
$formData = array(
				'class'	=> 'frmClient',
				'id' 	=> 'frmClient'
			);

// Company
$formCompany = array(
				'name'			=> 'company',
				'id'			=> 'company',
				'placeholder'	=> 'company name',
				'maxlength'		=> '50',
				'size'			=> '25',
				'class'			=> 'clearfix',
				'value'			=> $company
            );

// First Name
$formFirstName = array(
				'name'			=> 'fname',
				'id'			=> 'fname',
				'placeholder'	=> 'first name',
				'maxlength'		=> '50',
				'size'			=> '25',
				'class'			=> 'clearfix',
				'value'			=> $fname
			);

$formLastName = array(
				'name'			=> 'lname',
				'id'			=> 'lname',
				'placeholder'	=> 'last name',
				'maxlength'		=> '50',
				'size'			=> '25',
				'class'			=> 'clearfix',
				'value'			=> $lname
			);

$formStatusOptions = array(
				"active" => "active",
				"cancelled" => "cancelled",
				"on hold" => "on hold",
				"skip" => "skip"
			);

// Mailing Schedule
$found = false;
$formScheduleOptions = "<option value=''>(unassigned)</option>";
if(!empty($mailing_schedule)) {
	foreach($schedule as $entry) {
		if($mailing_schedule===$entry['ListLabel']) {
			$found = true;
		}
	}
}
if(!$found && !empty($mailing_schedule)) {
	$formScheduleOptions .= "<option value='$mailing_schedule' selected='selected'>$mailing_schedule</option>";
}
foreach($schedule as $entry) {
	$formScheduleOptions .= "<option ";
	if($entry['ListLabel']===$mailing_schedule) {
		$formScheduleOptions .= "selected='selected' ";
	}
	$formScheduleOptions .= "value='" . $entry['ListLabel'] . "'>" . $entry['ListLabel'] . "</option>\r\n";
}
$formScheduleOptions .= "<option value='unique'>Unique</option>";
// End Mailing Schedule

$formTeamsListOptions = "<option value=''>(unassigned)</option>";
foreach($teamsList as $entry) {
	$formTeamsListOptions .= "<option ";
	if($entry['ListUID']===$team) {
		$formTeamsListOptions .= "selected='selected' ";
	}
	$formTeamsListOptions .= "value='" . $entry['ListUID'] . "'>" . $entry['ListLabel'] . "</option>\r\n";
}

$formTeamMemberOptions = "<option value=''>(unassigned)</option>";
foreach($teamMembers as $member) {
	$formTeamMemberOptions .= "<option ";
	if($member['id']===$pm_id) {
		$formTeamMemberOptions .= "selected='selected' ";
	}
	$formTeamMemberOptions .= "value='" . $member['id'] . "'>" . $member['lname'] . ", " . $member['fname'] . "</option>\r\n";
}

$formWriterOptions = "<option value=''>(unassigned)</option>";
foreach($teamMembers as $member) {
	$formWriterOptions .= "<option ";
	if($member['id']===$writer) {
		$formWriterOptions .= "selected='selected' ";
	}
	$formWriterOptions .= "value='" . $member['id'] . "'>" . $member['lname'] . ", " . $member['fname'] . "</option>\r\n";
}

$formDesignerOptions = "<option value=''>(unassigned)</option>";
foreach($teamMembers as $member) {
	$formDesignerOptions .= "<option ";
	if($member['id']===$designer) {
		$formDesignerOptions .= "selected='selected' ";
	}
	$formDesignerOptions .= "value='" . $member['id'] . "'>" . $member['lname'] . ", " . $member['fname'] . "</option>\r\n";
}

$formPhone = array(
				'name'			=> 'phone',
				'id'			=> 'phone',
				'placeholder'	=> 'ex. 831-555-1234',
				'maxlength'		=> '50',
				'size'			=> '15',
				'class'			=> 'clearfix',
				'value'			=> $phone
			);

$formEmail = array(
				'name'			=> 'email',
				'id'			=> 'email',
				'placeholder'	=> 'email@example.com',
				'maxlength'		=> '100',
				'size'			=> '25',
				'class'			=> 'clearfix',
				'value'			=> $email
			);

$formSubmit = array(
				'name'	=> 'submit',
				'id'	=> 'submit',
				'value'	=> 'Login'
			);

$formDate_sold = array(
		'name'			=> 'date_sold',
		'id'			=> 'date_sold',
		'placeholder' 	=> '01/02/2015',
		'class'			=> 'clearfix dateMe',
		'value' 		=> $date_sold
	);
$formDate_onboarded = array(
		'name'			=> 'date_onboarded',
		'id'			=> 'date_onboarded',
		'placeholder' 	=> '01/02/2015',
		'class'			=> 'clearfix dateMe',
		'value' 		=> $date_onboarded
	);
$formSale_source = array(
		'name'			=> 'sale_source',
		'id'			=> 'sale_source',
		'placeholder' 	=> 'Sale Source',
		'class'			=> 'clearfix',
		'value' 		=> $sale_source
	);
$formPieces_mailed = array(
		'name'			=> 'pieces_mailed',
		'id'			=> 'pieces_mailed',
		'placeholder' 	=> '10',
		'class'			=> 'clearfix',
		'value' 		=> $pieces_mailed
	);
$formPrice_per_pieces = array(
		'name'			=> 'price_per_pieces',
		'id'			=> 'price_per_pieces',
		'placeholder' 	=> '10.50',
		'class'			=> 'clearfix',
		'value' 		=> $price_per_pieces
	);
$formTeam = array(
		'name'			=> 'team',
		'id'			=> 'team',
		'placeholder' 	=> 'team',
		'class'			=> 'clearfix',
		'value' 		=> $team
	);
$formWriter = array(
		'name'			=> 'writer',
		'id'			=> 'writer',
		'placeholder' 	=> 'writer',
		'class'			=> 'clearfix',
		'value' 		=> $writer
	);
$formDesigner = array(
		'name'			=> 'designer',
		'id'			=> 'designer',
		'placeholder' 	=> 'designer',
		'class'			=> 'clearfix',
		'value' 		=> $designer
	);
$formTotal_pages = array(
		'name'			=> 'total_pages',
		'id'			=> 'total_pages',
		'placeholder' 	=> '10',
		'class'			=> 'clearfix',
		'value' 		=> $total_pages
	);
$formUnique_pages = array(
		'name'			=> 'unique_pages',
		'id'			=> 'unique_pages',
		'placeholder' 	=> '10',
		'class'			=> 'clearfix',
		'value' 		=> $unique_pages
	);
$formCustom_content = array(
		'name'			=> 'custom_content',
		'id'			=> 'custom_content',
		'placeholder' 	=> '10',
		'class'			=> 'clearfix',
		'value' 		=> $custom_content
	);
$formFiller_content = array(
		'name'			=> 'filler_content',
		'id'			=> 'filler_content',
		'placeholder' 	=> '10',
		'class'			=> 'clearfix',
		'value' 		=> $filler_content
	);
$formClient_submitted_content = array(
		'name'			=> 'client_submitted_content',
		'id'			=> 'client_submitted_content',
		'placeholder' 	=> '10',
		'class'			=> 'clearfix',
		'value' 		=> $client_submitted_content
	);
$formSide_campaigns = array(
		'name'			=> 'side_campaigns',
		'id'			=> 'side_campaigns',
		'placeholder' 	=> 'Side campaigns',
		'class'			=> 'clearfix',
		'value' 		=> $side_campaigns
	);
$formMailing_Schedule = array(
		'name'			=> 'mailing_schedule',
		'id'			=> 'mailing_schedule_text',
		'placeholder' 	=> 'Mailing Schedule',
		'class'			=> 'clearfix',
		'disabled'		=> 'disabled',
		'style'			=> 'display:none;'
	);
$formReturn_date = array(
		'name'			=> 'return_date',
		'id'			=> 'return_date',
		'placeholder' 	=> '01/02/2015',
		'class'			=> 'clearfix dateMe',
		'value' 		=> $return_date
	);
$formLayout_Guide = array(
		'name'			=> 'layout_guide',
		'id'			=> 'layout_guide',
		'placeholder'	=> 'Layout guide',
		'class'			=> 'clearfix',
		'value'			=> $layout_guide,
		'rows'			=> '10',
		'cols'			=> '50'
	);
$formNotes = array(
		'name'			=> 'notes',
		'id'			=> 'notes',
		'placeholder'	=> 'Notes',
		'class'			=> 'clearfix',
		'rows'			=> '20',
		'cols'			=> '70'
	);

$arrDemographic = explode(",",$client_demographics);
$formClientDemographicOptions = "<div>";
foreach($demographics as $item) {
	$label = $item["ListLabel"];
	$value = $item["ListUID"];

	$formClientDemographicOptions .= "<div class='checkbox_wrapper'><input type='checkbox' name='demographics[]' value='$value' ";
	if(in_array($value, $arrDemographic)) {
		$formClientDemographicOptions .= " checked='checked'";
	}
	$formClientDemographicOptions .= "/>&nbsp;$label</div>";
	/*if($item["label"]==$article_demographic) {
		$formClientDemographicOptions .= " selected='selected'";
	}*/
}
$formClientDemographicOptions .= "</div>";
?>
<h1>
    <?php
    echo "$company - $fname $lname";
    if (!empty($email)) {
        echo "&nbsp;";
        echo "<a href='mailto:$email' class='notBtn'><i class=\"fa fa-envelope\"></i></a>";
        echo "&nbsp;$email";
    }
    if (!empty($phone)) {
        echo "&nbsp;";
        echo "<a href='tel:$phone' class='notBtn'><i class=\"fa fa-phone\"></i></a>";
        echo "&nbsp;$phone";
    }
    if (!empty($status)) {
        echo "&nbsp;";
        switch ($status) {
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
<?php if (!empty($return_date)) {
    echo "<p>Returns $return_date</p>";
} ?>
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
<?php echo form_open('clients/update', $formData);?>
<div class="tabs">
	<ul>
		<li><a href="#tabs-1">Basics</a></li>
		<li><a href="#tabs-2">Mailing</a></li>
		<li><a href="#tabs-3">Articles (<?php echo $articlesCount; ?>)</a></li>
		<li><a href="#tabs-4">Sales</a></li>
		<li><a href="#tabs-5">Team</a></li>
		<li><a href="#tabs-6">Content</a></li>
		<li><a href="#tabs-7">Notes</a></li>
		<?php if($_SESSION["UserRole"]==="admin"): ?>
		<li><a href="#tabs-admin">Admin</a></li>
		<?php endif; ?>
	</ul>
	<div id="tabs-1">
		<table class="tblClientDetails" cellpadding="3" cellspacing="0">
			<tr>
				<td>Company Name</td>
				<td>
					<?php echo form_input($formCompany); ?>
					<div id='company_already_added' style='display:none;'>A client with this name has already been added. Please add another.</div>
				</td>
			</tr>
			<tr>
				<td>First Name</td>
				<td><?php echo form_input($formFirstName); ?></td>
			</tr>
			<tr>
				<td>Last Name</td>
				<td><?php echo form_input($formLastName); ?></td>
			</tr>
			<tr>
				<td>Status</td>
				<td><?php echo form_dropdown('status',$formStatusOptions,$status); ?></td>
			</tr>
			<tr id="returnDateRow">
				<td>Return Date</td>
				<td><?php echo form_input($formReturn_date); ?></td>
			</tr>
			<tr>
				<td>Phone</td>
				<td><?php echo form_input($formPhone); ?></td>
			</tr>
			<tr>
				<td>Email</td>
				<td><?php echo form_input($formEmail); ?></td>
			</tr>
		</table>
	</div>
	<div id="tabs-2">
		<table class="tblClientDetails" cellpadding="3" cellspacing="0">
			<tr>
				<td>Mail Date</td>
				<td>
					<select name="mail_date">
						<?php
						$arrDates = array("","5th","15th","20th","25th","30th");
						foreach($arrDates as $date) {
							echo "<option value='$date'";
							if(!empty($mail_date) && $mail_date==$date) {
								echo " selected='selected'";
							}
							echo ">$date</option>";
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Mailing Schedule</td>
				<td>
					<?php echo form_input($formMailing_Schedule); ?>
					<select name='mailing_schedule' id='mailing_schedule_select'>
						<?php echo $formScheduleOptions; ?>
					</select>
					<button style="display:none;" id="flipToSelect">Use List</button>
				</td>
			</tr>
			<tr>
				<td>Package Type</td>
				<td><input name="package_type" type='text' value="<?php echo $package_type; ?>" /></td>
			</tr>
			<tr>
				<td>List Size</td>
				<td><input name="list_size" type='text' value="<?php echo $list_size; ?>" /></td>
			</tr>
			<tr>
				<td>Versions</td>
				<td><input name="versions" type='text' value="<?php echo $versions; ?>" /></td>
			</tr>
			<tr>
				<td>Demographics</td>
				<td>
					<?php echo $formClientDemographicOptions; ?>
				</td>
			</tr>
			<tr>
				<td>Side Campaigns</td>
				<td><?php echo form_input($formSide_campaigns); ?></td>
			</tr>
		</table>
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
	</div>
	<div id="tabs-4">
		<table class="tblClientDetails" cellpadding="3" cellspacing="0">
			<tr>
				<td>Date Sold</td>
				<td><?php echo form_input($formDate_sold); ?></td>
			</tr>
			<tr>
				<td>Date Onboarded</td>
				<td><?php echo form_input($formDate_onboarded); ?></td>
			</tr>
			<tr>
				<td>Sale Source</td>
				<td><?php echo form_input($formSale_source); ?></td>
			</tr>
			<tr>
				<td>Price Per Pieces</td>
				<td><?php echo form_input($formPrice_per_pieces); ?></td>
			</tr>
		</table>
	</div>
	<div id="tabs-5">
		<table class="tblClientDetails" cellpadding="3" cellspacing="0">
			<tr>
				<td>Project Manager</td>
				<td>
					<select name='owned_by' id='owned_by'>
						<?php echo $formTeamMemberOptions; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Team</td>
				<td>
					<select name='team' id='team'>
						<?php echo $formTeamsListOptions; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Writer</td>
				<td>
					<select name='writer' id='writer'>
						<?php echo $formWriterOptions; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Designer</td>
				<td>
					<select name='designer' id='designer'>
						<?php echo $formDesignerOptions; ?>
					</select>
				</td>
			</tr>
		</table>
	</div>
	<div id="tabs-6">
		<table class="tblClientDetails" cellpadding="3" cellspacing="0">
			<tr>
				<td>Total Pages</td>
				<td><?php echo form_input($formTotal_pages); ?></td>
			</tr>
			<tr>
				<td>Unique Pages</td>
				<td><?php echo form_input($formUnique_pages); ?></td>
			</tr>
			<tr>
				<td>Custom Content</td>
				<td><?php echo form_input($formCustom_content); ?></td>
			</tr>
			<tr>
				<td>Filler Content</td>
				<td><?php echo form_input($formFiller_content); ?></td>
			</tr>
			<tr>
				<td>Client Submitted Content</td>
				<td><?php echo form_input($formClient_submitted_content); ?></td>
			</tr>
			<tr>
				<td>Layout Guide</td>
				<td><?php echo form_textarea($formLayout_Guide); ?></td>
			</tr>
		</table>
	</div>
	<div id="tabs-7">
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
                    <tr>
                        <td colspan="3">
                            <?php echo form_textarea($formNotes); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
	</div>
	<?php if($_SESSION["UserRole"]==="admin"): ?>
	<div id="tabs-admin">
		<?php echo anchor("clients/delete/$userid","Delete client","class='hrefConfirm'"); ?>
	</div>
	<?php endif; ?>
</div>
<input type="hidden" name="id" value="<?php echo $userid; ?>" />
<?php
if(($_SESSION["UserID"]===$pm_id) || ($_SESSION["UserRole"]==="admin")) {
	echo form_submit('update', 'Update');
}
echo form_close();
?>
<div style="display:none;" id="hrefConfirm" title="Are you sure?">
	<p>This action is permanent. Are you sure you wish to continue?</p>
</div>