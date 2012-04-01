<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Nickname</th>
			<th>Email</th>
			<th>Last Activity</th>
			<th>Registered</th>
			<th>Status</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?
		foreach($users as $user){
			?>
			<tr>
				<td><?php echo $user['nickname']; ?></td>
				<td><?php echo $user['email']; ?></td>
				<td><?php echo date('Y-m-d H:i', $user['lastActive']); ?></td>
				<td><?php echo date('Y-m-d H:i', $user['registeredAt']); ?></td>
				<td><?php echo $this->user_model->getHumanStatus($user['userID']); ?></td>
				<th>
					<a href="admin/user/view/<?php echo $user['userID'];?>" class="btn btn-small"><i class="icon-eye-open"></i> View</a>
					<a href="admin/user/edit/<?php echo $user['userID'];?>" class="btn btn-small btn-primary"><i class="icon-pencil icon-white"></i> Edit</a>
					<a href="admin/user/remove/<?php echo $user['userID'];?>" class="btn btn-small btn-danger"><i class="icon-remove icon-white"></i> Delete</a>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>
