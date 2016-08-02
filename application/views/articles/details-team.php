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


echo anchor("/Articles/view","Article List");
?>
<Br /><Br />
<h1><?php echo $article_name; ?></h1>
<p>
<?php
if(!empty($article_uploaded)):
    echo "Uploaded " . date('F d, Y',strtotime($article_uploaded)) . ". ";
endif;
if(!empty($article_created)):
    echo "Created " . date('F d, Y',strtotime($article_created)) . ". ";
endif;
?>
</p>
<div class="tabs">
	<ul>
		<li><a href="#tabs-1">Basic Information</a></li>
		<li><a href="#tabs-2">Usage (<?php echo $usage_count; ?>)</a></li>
		<?php if($_SESSION["UserRole"]=="admin") { echo "<li><a href='#tabs-3'>Admin</a></li>"; } ?>
	</ul>
	<div id="tabs-1">
            <?php echo anchor("/Articles/AssignToClient/$id","Assign to Client"); ?>
            <table class="noStyle">
                <tr>
                    <td>
                        <table class="tblArticleDetails" cellpadding="3" cellspacing="0">
                            <tr>
                                <td nowrap>Attachments</td>
                                <td>
                                    <?php
                                    if(!empty($article_attachment_sm)) {
                                        echo "<a href='" . base_url() . $article_attachment_sm . "'>Small</a><br />";
                                    }
                                    if(!empty($article_attachment_md)) {
                                        echo "<a href='" . base_url() . $article_attachment_md . "'>Medium</a><br />";
                                    }
                                    if(!empty($article_attachment_lg)) {
                                        echo "<a href='" . base_url() . $article_attachment_lg . "'>Large</a><br />";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap>Images</td>
                                <td>
                                    <?php
                                    if(!empty($article_image_sm)) {
                                        echo "<a target='_blank' href='" . base_url() . $article_image_sm . "'>Small</a><br />";
                                    }
                                    if(!empty($article_image_md)) {
                                        echo "<a target='_blank' href='" . base_url() . $article_image_md . "'>Medium</a><br />";
                                    }
                                    if(!empty($article_image_lg)) {
                                        echo "<a target='_blank' href='" . base_url() . $article_image_lg . "'>Large</a><br />";
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap>Word Counts</td>
                                <td>
                                    <?php
                                    if(!empty($article_wordcount_sm)): echo "Small: $article_wordcount_sm<Br />"; endif;
                                    if(!empty($article_wordcount_md)): echo "Medium: $article_wordcount_md<Br />"; endif;
                                    if(!empty($article_wordcount_lg)): echo "Large: $article_wordcount_lg <Br />"; endif;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap>Category</td>
                                <td>
                                    <?php echo $articleLabels; ?>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap>Keywords</td>
                                <td><?php echo $article_keywords ?></td>
                            </tr>
                            <tr>
                                <td nowrap>Demographic</td>
                                <td>
                                    <?php echo $demographicLabels; ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="50%" cellspacing="tabs-3" cellpadding="3" style="padding:1.5em;line-height:2em;">
                            <h1>Article Preview</h1>
                            <?php echo $article_description; ?>
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

<div style="display:none;" id="hrefConfirm" title="Are you sure?">
	<p>This action is permanent. Are you sure you wish to continue?</p>
</div>