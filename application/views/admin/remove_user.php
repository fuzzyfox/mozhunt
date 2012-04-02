<?php echo form_open('admin/user/remove/'.$badID, array('class'=>'form-horizontal')); ?>
	<div class="alert alert-block">
		<h4 class="alert-heading">Warning!</h4>
		You are about to remove the user <?php echo $nickname; ?> from the system.
		<h4>THIS CANNOT BE UNDONE!</h4>
		Please ensure that you have the right user before clicking the Delete
		button.
		<dl>
			<dt>Nickname:</dt>
			<dd><?php echo $nickname; ?></dd>
			<dt>Email Address:</dt>
			<dd><?php echo $email; ?></dd>
			<dt>User Level:</dt>
			<dd><?php echo $this->user_model->getHumanStatus($badID); ?></dd>
		</dl>
	</div>
	<div class="form-actions">
		<button type="submit" name="submit" value="true" class="btn btn-danger">Delete</button>
		<a href="admin/user" class="btn">Cancel</a>
	</div>
</form>