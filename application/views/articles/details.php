<?php
$this->load->helper('form');

foreach($details as $detail) {
	$id = 						$detail["id"];
	$uid = 						$detail["uid"];
	$article_name = 			$detail["article_name"];
	$article_path = 			$detail["article_path"];
	$article_category = 		$detail["article_category"];
	$category_label = 			$detail["category_label"];
	$article_demographic = 		$detail["article_demographic"];
	$article_keywords = 		$detail["article_keywords"];
	$article_description = 		$detail["article_description"];
	$linked_images = 			$detail["linked_images"];
	$article_attachment_sm =	$detail["article_attachment_sm"];
	$article_attachment_md =	$detail["article_attachment_md"];
	$article_attachment_lg =	$detail["article_attachment_lg"];
	$article_wordcount_sm =		$detail["article_wordcount_sm"];
	$article_wordcount_md =		$detail["article_wordcount_md"];
	$article_wordcount_lg =		$detail["article_wordcount_lg"];
	$article_image_sm =			$detail["article_image_sm"];
	$article_image_md =			$detail["article_image_md"];
	$article_image_lg =			$detail["article_image_lg"];
	$article_uploaded =			$detail["article_uploaded"];
	$article_created = 			$detail["article_created"];
}

if(!empty($article_created)) {
	$article_created = date("m/d/Y",strtotime($article_created));
}

// Form
$formData = array(
				'class'	=> 'frmArticle',
				'id' 	=> 'frmArticle'
			);

// Article Name
$formArticleName = array(
				'name'			=> 'article_name',
				'id'			=> 'article_name',
				'placeholder'	=> 'article name',
				'maxlength'		=> '50',
				'size'			=> '25',
				'class'			=> 'clearfix',
				'value'			=> $article_name
            );

$formArticleAttachment_sm = array(
				'name'	=> 'article_attachment_sm',
				'id'	=> 'article_attachment_sm'
			);

$formArticleAttachment_md = array(
				'name'	=> 'article_attachment_md',
				'id'	=> 'article_attachment_md'
			);

$formArticleAttachment_lg = array(
				'name'	=> 'article_attachment_lg',
				'id'	=> 'article_attachment_lg'
			);

$formArticleImage_sm = array(
				'name'	=> 'article_image_sm',
				'id'	=> 'article_image_sm'
			);

$formArticleImage_md = array(
				'name'	=> 'article_image_md',
				'id'	=> 'article_image_md'
			);

$formArticleImage_lg = array(
				'name'	=> 'article_image_lg',
				'id'	=> 'article_image_lg'
			);

$formArticleDescription = array(
				'name'	=> 'article_description',
				'id'	=> 'article_description',
				'value'	=> $article_description,
				'rows'  => '5',
				'cols'	=> '50'
);

$formArticleCreated = array(
		'name'	=> 'article_created',
		'id'	=> 'article_created',
		'value'	=> $article_created,
		'placeholder' => '01/04/2010',
		'class'		=> 'dateMe'
	);

// Article Word Count
$formArticleWordCount_sm = array(
				'name'			=> 'article_wordcount_sm',
				'id'			=> 'article_wordcount_sm',
				'placeholder'	=> 'word count',
				'maxlength'		=> '9',
				'size'			=> '12',
				'class'			=> 'clearfix',
				'value'			=> $article_wordcount_sm
			);

$formArticleWordCount_md = array(
				'name'			=> 'article_wordcount_md',
				'id'			=> 'article_wordcount_md',
				'placeholder'	=> 'word count',
				'maxlength'		=> '9',
				'size'			=> '12',
				'class'			=> 'clearfix',
				'value'			=> $article_wordcount_md
			);

$formArticleWordCount_lg = array(
				'name'			=> 'article_wordcount_lg',
				'id'			=> 'article_wordcount_lg',
				'placeholder'	=> 'word count',
				'maxlength'		=> '9',
				'size'			=> '12',
				'class'			=> 'clearfix',
				'value'			=> $article_wordcount_lg
			);

$formArticleKeywords = array(
				'name'			=> 'article_keywords',
				'id'			=> 'article_keywords',
				'placeholder'	=> 'key words separated by comma',
				'maxlength'		=> '100',
				'size'			=> '50',
				'class'			=> 'clearfix',
				'value'			=> $article_keywords
			);

$arrDemographic = explode(",",$article_demographic);
$formArticleDemographicOptions = "<div>";
foreach($demographics as $item) {
	$label = $item["label"];
	$value = $item["uid"];

	$formArticleDemographicOptions .= "<div class='checkbox_wrapper'><input type='checkbox' name='article_demographic[]' value='$value' ";
	if(in_array($value, $arrDemographic)) {
		$formArticleDemographicOptions .= " checked='checked'";
	}
	$formArticleDemographicOptions .= "/>&nbsp;$label</div>";
	/*if($item["label"]==$article_demographic) {
		$formArticleDemographicOptions .= " selected='selected'";
	}*/
}
$formArticleDemographicOptions .= "</div>";

$arrArticleTypeOptions = explode(",",$article_category);
$formArticleTypeOptions = "<div>";
foreach($article_types as $item) {
	$label = $item["Label"];
	$value = $item["UID"];

	$formArticleTypeOptions .= "<div class='checkbox_wrapper'><input type='checkbox' name='article_category[]' value='$value' ";
	if(in_array($value, $arrArticleTypeOptions)) {
		$formArticleTypeOptions .= " checked='checked'";
	}
	$formArticleTypeOptions .= "/>&nbsp;$label</div>";
	/*if($item["label"]==$article_demographic) {
		$formArticleTypeOptions .= " selected='selected'";
	}*/
}
$formArticleTypeOptions .= "</div>";

$formSubmit = array(
				'name'	=> 'submit',
				'id'	=> 'submit',
				'value'	=> 'Submit'
			);

echo anchor("/Articles/view","Article List");
?>

<?php echo form_open_multipart('articles/update', $formData);?>
<div class="tabs">
	<ul>
		<li><a href="#tabs-1">Basic Information</a></li>
		<li><a href="#tabs-2">Usage (<?php echo $usage_count; ?>)</a></li>
		<?php if($_SESSION["UserRole"]=="admin") { echo "<li><a href='#tabs-3'>Admin</a></li>"; } ?>
	</ul>
	<div id="tabs-1">
		<?php echo anchor("/Articles/AssignToClient/$id","Assign to Client"); ?>
		<table class="tblArticleDetails" cellpadding="3" cellspacing="0">
			<tr>
				<td>Article Name</td>
				<td>
					<?php echo form_input($formArticleName); ?>
				</td>
			</tr>
			<tr>
				<td>Date Uploaded</td>
				<td>
					<?php echo date('F d, Y',strtotime($article_uploaded)); ?>
				</td>
			</tr>
			<tr>
				<td>Date Created</td>
				<td>
					<?php echo form_input($formArticleCreated); ?>
				</td>
			</tr>
			<tr>
				<td>Attachment (sm)</td>
				<td>
					<?php
					if(!empty($article_attachment_sm)) {
						echo "<a href='" . base_url() . $article_attachment_sm . "'>Download</a>";
					}
					echo form_upload($formArticleAttachment_sm); ?>
				</td>
			</tr>
			<tr>
				<td>Image (sm)</td>
				<td>
					<?php
					if(!empty($article_image_sm)) {
						echo "<a target='_blank' href='" . base_url() . $article_image_sm . "'>View in New Window</a>";
					}
					
					echo form_upload($formArticleImage_sm); ?>
				</td>
			</tr>
			<tr>
				<td>Word Count (sm)</td>
				<td>
					<?php echo form_input($formArticleWordCount_sm);?>
				</td>
			</tr>
			<tr>
				<td>Attachment (md)</td>
				<td>
					<?php
					if(!empty($article_attachment_md)) {
						echo "<a href='" . base_url() . $article_attachment_md . "'>Download</a>";
					}
					echo form_upload($formArticleAttachment_md); ?>
				</td>
			</tr>
			<tr>
				<td>Image (md)</td>
				<td>
					<?php
					if(!empty($article_image_md)) {
						echo "<a target='_blank' href='" . base_url() . $article_image_md . "'>View in New Window</a>";
					}
					
					echo form_upload($formArticleImage_md); ?>
				</td>
			</tr>
			<tr>
				<td>Word Count (md)</td>
				<td>
					<?php echo form_input($formArticleWordCount_md);?>
				</td>
			</tr>
			<tr>
				<td>Attachment (lg)</td>
				<td>
					<?php
					if(!empty($article_attachment_lg)) {
						echo "<a href='" . base_url() . $article_attachment_lg . "'>Download</a>";
					}
					echo form_upload($formArticleAttachment_lg); ?>
				</td>
			</tr>
			<tr>
				<td>Image (lg)</td>
				<td>
					<?php
					if(!empty($article_image_lg)) {
						echo "<a target='_blank' href='" . base_url() . $article_image_lg . "'>View in New Window</a>";
					}
					
					echo form_upload($formArticleImage_lg); ?>
				</td>
			</tr>
			<tr>
				<td>Word Count (lg)</td>
				<td>
					<?php echo form_input($formArticleWordCount_lg);?>
				</td>
			</tr>
			<tr>
				<td>Article Type</td>
				<td>
					<?php echo $formArticleTypeOptions; ?>
				</td>
			</tr>
			<tr>
				<td>Keywords</td>
				<td><?php echo form_input($formArticleKeywords); ?></td>
			</tr>
			<tr>
				<td>Description</td>
				<td><?php echo form_textarea($formArticleDescription); ?></td>
			</tr>
			<tr>
				<td>Demographic</td>
				<td>
					<?php echo $formArticleDemographicOptions; ?>
				</td>
			</tr>
		</table>
	</div>
	<div id="tabs-2">
		<table cellpadding='3' cellspacing='0' class='dataTable'>
			<thead>
				<tr>
					<th>Company</th>
					<th>Edition</td>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach($usage as $item) {
					$name = $item["company_name"];
					$user = $item["user_id"];
					$edition = date("M, Y",strtotime($item["edition"]));
					echo "
						<tr>
							<td>$name</td>
							<td>$edition</td>
						</tr>
					";
				}
				?>
			</tbody>
		</table>
	</div>
	<?php if($_SESSION["UserRole"]=="admin"): ?>
	<div id="tabs-3">
		<?php echo anchor("articles/delete/$id","Delete this article","class='hrefConfirm'"); ?>
	</div>
	<?php endif; ?>

</div>
<input type="hidden" name="id" value="<?php echo $id; ?>" />
<?php

echo form_submit('update', 'Update');

echo form_close();
?>
<div style="display:none;" id="hrefConfirm" title="Are you sure?">
	<p>This action is permanent. Are you sure you wish to continue?</p>
</div>