<?php echo anchor('Categories/add', 'Add Category'); ?>
<table class="dataTable" id="tblCategories">
	<thead>
		<tr>
			<th>Label</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach($categories as $category) {
			$label = $category["Label"];
			$catID = $category["UID"];
			echo "
				<tr class='clickable'>
					<td>$label</td>
					<td><a href='/index.php/Categories/edit/$catID'>Edit</a></td>
					<td><a href='/index.php/Subcategories/view/$catID'>Edit Subcategories</a></td>
				</tr>
				";
		}
		?>
	</tbody>
</table>
