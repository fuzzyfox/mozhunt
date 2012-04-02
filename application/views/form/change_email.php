<?php echo form_open('user/account/email', array('class'=>'form-horizontal')); ?>
	<fieldset>
		<legend><?php echo $this->lang->line('form.change.email.legend'); ?></legend>
		<div class="alert alert-block">
			<h4 class="alert-heading">Warning!</h4>
			You will be logged out on success and will be unable to log back in untill 
			you have reactivated your account using the verification link we send to
			your new email address.
		</div>
		<div class="control-group<?php echo (form_error('email'))?' error':null; ?>">
			<label for="email" class="control-label"><?php echo $this->lang->line('form.change.email.label'); ?></label>
			<div class="controls">
				<input type="text" name="email" />
				<?php echo form_error('email', '<span class="help-inline">', '</span>'); ?>
			</div>
		</div>
		<div class="control-group<?php echo (form_error('emailconf'))?' error':null; ?>">
			<label for="emailconf" class="control-label"><?php echo $this->lang->line('form.change.emailconf.label'); ?></label>
			<div class="controls">
				<input type="text" name="emailconf" />
				<?php echo form_error('emailconf', '<span class="help-inline">', '</span>'); ?>
			</div>
		</div>
		<div class="control-group<?php echo (form_error('password'))?' error':null; ?>">
			<label for="password" class="control-label"><?php echo $this->lang->line('form.change.password.label'); ?></label>
			<div class="controls">
				<input type="password" name="password" />
				<?php echo form_error('password', '<span class="help-inline">', '</span>'); ?>
			</div>
		</div>
		<div class="form-actions">
			<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('form.change.submit'); ?></button>
			<a href="admin/user" class="btn"><?php echo $this->lang->line('form.change.cancel'); ?></a>
		</div>
	</fieldset>
</form>