<?php
echo anchor("/Reports/view","Back to Reports");

if($total): ?>
<br /><br />
<div class='totalBox'>
	<label>Grand Total</label>
	<div class='value grandTotal'></div>
</div>
<br />
<?php endif; ?>
<table id='report'>
	<thead>
		<tr>
			<?php
			$arrHeader = array_shift($report);
			foreach($arrHeader as $item) {
				echo "<th>$item</th>";
			}
			?>
		</tr>
	</thead>
	<tbody>
		<?php
		$tally = 0;
		foreach($report as $row) {
			if($reportid!=="7") {
				echo "<tr>";
				foreach($row as $cell) {
					echo "<td>$cell</td>";
					if(is_numeric($cell)) {
						$tally += $cell;
					}
				}
				echo "</tr>";
			}
			// Client Audit Report
			else {
				$showRow = false;
				$rowContent = "";
				$fullContent = "";
				foreach ($row as $cell) {
					if(empty($cell)) {
						$showRow = true;
						$rowContent .= "<td class='error'>(blank)</td>";
					}
					else {
						$rowContent .= "<td>$cell</td>";
					}
				}
				if($showRow) {
					echo "<tr>$rowContent</tr>";
				}
			}
		}
		if($total) {
			echo "<tr id='grand_total'><td><span class='ghost'>ZZZ</span>Grand Total</td><td id='tally'>$tally</td></tr>";
		}
		?>
	</tbody>
</table>