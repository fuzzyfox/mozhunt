<?php echo form_open('user/join', array('class'=>'form-horizontal')); ?>
	<?php if(validation_errors()): ?>
		<div class="alert alert-error"><a class="close" data-dismiss="alert">&times;</a><?php echo $this->lang->line('form.join.error'); ?></div>
	<?php endif; ?>
	<fieldset>
		<legend><?php echo $this->lang->line('form.join.legend'); ?></legend>
		
		<div class="control-group<?php echo (form_error('nickname'))?' error':null; ?>">
			<label for="nickname" class="control-label"><?php echo $this->lang->line('form.join.nickname.label'); ?></label>
			<div class="controls">
				<input type="text" name="nickname" value="<?php echo set_value('nickname'); ?>" placeholder="<?php echo $this->lang->line('form.join.nickname.placeholder'); ?>" />
				<?php echo form_error('nickname', '<span class="help-inline">', '</span>'); ?>
				<p class="help-block"><?php echo $this->lang->line('form.join.nickname.help'); ?></p>
			</div>
		</div>
		
		<div class="control-group<?php echo (form_error('email'))?' error':null; ?>">
			<label for="email" class="control-label"><?php echo $this->lang->line('form.join.email.label'); ?></label>
			<div class="controls">
				<input type="text" name="email" value="<?php echo set_value('email'); ?>" placeholder="<?php echo $this->lang->line('form.join.email.placeholder'); ?>" />
				<?php echo form_error('email', '<span class="help-inline">', '</span>'); ?>
				<p class="help-block"><?php echo $this->lang->line('form.join.email.help'); ?></p>
			</div>
		</div>
		
		<div class="control-group<?php echo (form_error('pw1'))?' error':null; ?>">
			<label for="" class="control-label"><?php echo $this->lang->line('form.join.password.label'); ?></label>
			<div class="controls">
				<input type="password" name="pw1" />
				<?php echo form_error('pw1', '<span class="help-inline">', '</span>'); ?>
			</div>
		</div>
		
		<div class="control-group<?php echo (form_error('pw2'))?' error':null; ?>">
			<label for="" class="control-label"><?php echo $this->lang->line('form.join.passwordconf.label'); ?></label>
			<div class="controls">
				<input type="password" name="pw2" />
				<?php echo form_error('pw2', '<span class="help-inline">', '</span>'); ?>
			</div>
		</div>
		
		<div class="control-group<?php echo (form_error('privacy')||form_error('tos'))?' error':null; ?>">
			<label for="legal" class="control-label"><?php echo $this->lang->line('form.join.legal.label'); ?></label>
			<div class="controls">
				<label for="privacy" class="checkbox">
					<input type="checkbox" id="privacy" name="privacy" value="true" />
					<?php echo $this->lang->line('form.join.privacy.statement'); ?>
				</label>
				<label for="tos" class="checkbox">
					<input type="checkbox" id="tos" name="tos" value="true" />
					<?php echo $this->lang->line('form.join.tos.statement'); ?>
				</label>
				<?php echo (form_error('privacy')||form_error('tos'))?'<p class="help-block">'.$this->lang->line('form.join.legal.error').'</p>':null; ?>
			</div>
		</div>
		
		<div class="form-actions">
			<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('form.join.submit'); ?></button>
		</div>
	</fieldset>
</form>