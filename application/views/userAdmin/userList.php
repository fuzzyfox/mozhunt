<?
// ./application/views/userAdmin/userList.php

/**
 * Shows a list of users
 * @author Steve "Uru" West <uru@mozhunt.com>
 * @version 2012-02-06
 */

?>
<table>
	<thead>
		<tr>
			<th>Nickname</th>
			<th>Email</th>
			<th>Last Activity</th>
			<th>Registered</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?
		foreach($users as $user){
			?>
			<tr>
				<td><?= $user['nickname']; ?></td>
				<td><?= $user['email']; ?></td>
				<td><?= date('Y-m-d H:i', $user['lastActive']); ?></td>
				<td><?= date('Y-m-d H:i', $user['registeredAt']); ?></td>
				<td><?= $user['deleteLink']; ?></td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>

<?
// End of file userList.php
