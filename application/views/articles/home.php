<?php
$addArticleData = array(
	"title"	=>"Add New Article"
);

echo anchor('Articles/view/add', 'Add New Article', $addArticleData);
?>
<table id="articles" class="dataTable" cellpadding="3" cellspacing="0">
	<thead>
		<tr>
			<th>Article</th>
			<th>Categories</th>
			<th>Demographic</th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach($articles as $article) {
			$id =					$article["id"];
			$uid =					$article["uid"];
			$article_name =			$article["article_name"];
			$article_path =			$article["article_path"];
			$article_category =		$article["article_category"];
			$article_demographic =	$article["article_demographic"];
			if(!empty($article_demographic)) {
				$article_demographic = implode(", ",$article_demographic);
			}
			$article_keywords =		$article["article_keywords"];
			$article_description =	$article["article_description"];
			$linked_images =		$article["linked_images"];

			echo "
				<tr class='clickable' data-id='$id'>
					<td>" . anchor("articles/details/$id",$article_name,"class='notBtn' title=\"$article_description\"") . "</td>
					<td>$article_category</td>
					<td>$article_demographic</td>
				</tr>";
		}
		?>
	</tbody>
</table>