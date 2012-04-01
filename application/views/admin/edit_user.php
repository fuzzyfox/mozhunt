<?php echo form_open('user/admin/edit/'.$userID, array('class'=>'form-horizontal')); ?>
	<fieldset>
		<legend>Edit <?php echo $nickname; ?>'s Details</legend>
		<div class="control-group<?php echo (form_error('nickname'))?' error':null; ?>">
			<label for="nickname" class="control-label">Nickname</label>
			<div class="controls">
				<input type="text" value="<?php echo $nickname; ?>" name="nickname" />
				<?php echo form_error('nickname', '<span class="help-inline">', '</span>'); ?>
			</div>
		</div>
		<div class="control-group<?php echo (form_error('email'))?' error':null; ?>">
			<label for="email" class="control-label">Email</label>
			<div class="controls"><input type="text" value="<?php echo $email; ?>" name="email" /></div>
			<?php echo form_error('email', '<span class="help-inline">', '</span>'); ?>
		</div>
		<div class="control-group<?php echo (form_error('pw1'))?' error':null; ?>">
			<label for="pw1" class="control-label">Password</label>
			<div class="controls">
				<input type="password" name="pw1" />
				<?php echo form_error('pw1', '<span class="help-inline">', '</span>'); ?>
				<p class="help-block"><strong>Note: </strong>This is the new password for the <?php echo $nickname;?>.
				They will not automatically be emailed about this password change.</p>
			</div>
		</div>
		<div class="control-group<?php echo (form_error('pw2'))?' error':null; ?>">
			<label for="pw2" class="control-label">Confirm Password</label>
			<div class="controls">
				<input type="password" name="pw2" />
				<?php echo form_error('pw2', '<span class="help-inline">', '</span>'); ?>
			</div>
		</div>
		<div class="form-actions">
			<button type="submit" class="btn btn-primary">Update</button>
			<a href="admin/user" class="btn">Cancel</a>
		</div>
	</fieldset>
</form>