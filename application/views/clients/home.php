<?php
$addClientData = array(
				"title"	=>"Add New Client"
			);
echo anchor('Clients/view/add', 'Add New Client', $addClientData);
?>
<table class="dataTable" id="clients" cellpadding="3" cellspacing="0">
	<thead>
		<tr>
			<th>Company</th>
			<th>Contact</th>
			<th>Mail Date</th>
			<th>Mailing Schedule</th>
			<th>Project Manager</th>
			<th>Writer</th>
			<th>Designer</th>
			<th>Team</th>
			<th>Package Type</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th>Company</th>
			<th>Contact</th>
			<th>Mail Date</th>
			<th>Mailing Schedule</th>
			<th>Project Manager</th>
			<th>Writer</th>
			<th>Designer</th>
			<th>Team</th>
			<th>Package Type</th>
		</tr>
	</tfoot>
	<tbody>
		<?php
		foreach($clientList as $client) {
			$id = $client["id"];
			$company = $client["company"];
			$contact = $client["fname"] . " " . $client["lname"];
			$status = $client["status"];
			$mail_date = $client["mail_date"];
			$mailing_schedule = $client["mailing_schedule"];
			$pm = $client["pm"];
			$writer = $client["writer"];
			$designer = $client["designer"];
			$package_type = $client["package_type"];
			$team = $client["team"];

			echo "
				<tr class='clickable' data-id='$id'>
					<td>
						" . anchor("clients/details/$id", $company,"class='notBtn'") . "
					</td>
					<td>$contact</td>
					<td>$mail_date</td>
					<td>$mailing_schedule</td>
					<td>$pm</td>
					<td>$writer</td>
					<td>$designer</td>
					<td>$team</td>
					<td>$package_type</td>
				</tr>";
		}
		?>
	</tbody>
</table>