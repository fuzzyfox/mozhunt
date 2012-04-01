<?php echo form_open('user/account/nickname', array('class'=>'form-horizontal')); ?>
	<fieldset>
		<legend><?php echo $this->lang->line('form.change.nickname.legend'); ?></legend>
		<div class="control-group">
			<label for="cpw" class="control-label"><?php echo $this->lang->line('form.change.nickname.current'); ?></label>
			<div class="controls">
				<input type="text" name="nickname" disabled="disabled" value="<?php echo $this->session->userdata('nickname'); ?>" />
			</div>
		</div>
		<div class="control-group<?php echo (form_error('nickname'))?' error':null; ?>">
			<label for="cpw" class="control-label"><?php echo $this->lang->line('form.change.nickname.label'); ?></label>
			<div class="controls">
				<input type="text" name="nickname" value="<?php echo set_value('nickname'); ?>" />
				<?php echo form_error('nickname', '<span class="help-inline">', '</span>'); ?>
			</div>
		</div>
		<div class="form-actions">
			<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('form.change.submit'); ?></button>
			<a href="user" class="btn"><?php echo $this->lang->line('form.change.cancel'); ?></a>
		</div>
	</fieldset>
</form>