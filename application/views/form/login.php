<?php	
	if($this->input->get('account') == 'activated')
	{
		echo '<div class="alert alert-success"><a class="close" data-dismiss="alert">&times;</a><strong>Your account is now active!</strong> You can now login and start finding them easter eggs!</div>';
	}
	elseif($this->input->get('account') == 'created')
	{
		echo '<div class="alert alert-info"><a class="close" data-dismiss="alert">&times;</a><strong>Your account has been created!</strong> An activation email was just sent to your email. You&rsquo;re almost there!</div>';
	}
	elseif($this->input->get('change') == 'email')
	{
		echo '<div class="alert alert-info"><a class="close" data-dismiss="alert">&times;</a><strong>Your account has been email has been changed!</strong> A reactivation email was just sent to your email. Your almost done!</div>';
	}
?>
<?php echo form_open('user/login', array('class'=>'form-horizontal')); ?>
	<fieldset>
		<legend><?php echo $this->lang->line('form.login.legend'); ?></legend>
		<?php if(validation_errors()): ?>
		<div class="alert alert-error">
			<?php echo validation_errors(); ?>
		</div>
		<?php endif; ?>
		<div class="control-group<?php echo (form_error('email'))?' error':null; ?>">
			<label for="email" class="control-label"><?php echo $this->lang->line('form.login.email.label'); ?></label>
			<div class="controls">
				<input type="text" name="email" class="span3" value=""<?php echo set_value('email'); ?> placeholder="<?php echo $this->lang->line('form.login.email.placeholder'); ?>" />
				<?php echo form_error('email', '<span class="help-inline">', '</span>'); ?>
			</div>
		</div>
		<div class="control-group<?php echo (form_error('password'))?' error':null; ?>">
			<label for="password" class="control-label"><?php echo $this->lang->line('form.login.password.label'); ?></label>
			<div class="controls">
				<input type="password" name="password" class="span3" placeholder="<?php echo $this->lang->line('form.login.password.placeholder'); ?>" />
				<?php echo form_error('password', '<span class="help-inline">', '</span>'); ?>
			</div>
		</div>
		<div class="form-actions">
			<p><?php echo $this->lang->line('form.login.new'); ?></p>
			<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('form.login.submit'); ?></button>
		</div>
	</fieldset>
</form>