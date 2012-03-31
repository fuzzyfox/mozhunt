<?php echo form_open('user/login', array('class'=>'form-horizontal')); ?>
	<fieldset>
		<legend><?php echo $this->lang->line('form.login.legend'); ?></legend>
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