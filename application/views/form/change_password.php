<?php echo form_open('user/account/password', array('class'=>'form-horizontal')); ?>
	<fieldset>
		<legend><?php echo $this->lang->line('form.change.password.legend'); ?></legend>
		<div class="control-group<?php echo (form_error('cpw'))?' error':null; ?>">
			<label for="cpw" class="control-label"><?php echo $this->lang->line('form.change.password.current.label'); ?></label>
			<div class="controls">
				<input type="password" name="cpw" />
				<?php echo form_error('cpw', '<span class="help-inline">', '</span>'); ?>
			</div>
		</div>
		<div class="control-group<?php echo (form_error('pw1'))?' error':null; ?>">
			<label for="pw1" class="control-label"><?php echo $this->lang->line('form.change.password.new.label'); ?></label>
			<div class="controls">
				<input type="password" name="pw1" />
				<?php echo form_error('pw1', '<span class="help-inline">', '</span>'); ?>
			</div>
		</div>
		<div class="control-group<?php echo (form_error('pw2'))?' error':null; ?>">
			<label for="pw2" class="control-label"><?php echo $this->lang->line('form.change.password.newconf.label'); ?></label>
			<div class="controls">
				<input type="password" name="pw2" />
				<?php echo form_error('pw2', '<span class="help-inline">', '</span>'); ?>
			</div>
		</div>
		<div class="form-actions">
			<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('form.change.password.submit'); ?></button>
			<a href="user" class="btn"><?php echo $this->lang->line('form.change.password.cancel'); ?></a>
		</div>
	</fieldset>
</form>