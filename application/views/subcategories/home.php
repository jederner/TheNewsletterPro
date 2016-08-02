<?php echo anchor("Subcategories/add/$parentID", "Add Subcategory"); ?>
<table class="dataTable" id="tblSubcategories">
	<thead>
		<tr>
			<th>Label</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach($subcategories as $subcategory) {
			$label = $subcategory["Label"];
			$catID = $subcategory["UID"];
			echo "
				<tr class='clickable'>
					<td>$label</td>
					<td><a href='/index.php/Subcategories/edit/$catID/$parentID'>Edit</a></td>
				</tr>
				";
		}
		?>
	</tbody>
</table>
