<?php echo anchor('Admin/addTeamMembers', 'Add New Team Member'); ?>
<table cellpadding='3' cellspacing='0' class='dataTable'>
	<thead>
		<tr>
			<th>Last Name</th>
			<th>First Name</th>
			<th>Email</th>
			<th>Team</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach($teamList as $member) {
			$teamId	= $member["id"];
			$lname 	= $member["lname"];
			$fname 	= $member["fname"];
			$email 	= $member["email"];
			$team 	= $member["team"];
			echo "
			<tr>
				<td>$lname</td>
				<td>$fname</td>
				<td><a href='mailto:$email'>$email</a></td>
				<td>$team</td>
				<td>" . anchor("Admin/editTeamMembers/$teamId", "Edit") . "</td>
			</tr>
			";
		}
		?>
	</tbody>
</table>