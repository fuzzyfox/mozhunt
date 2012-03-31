<?php echo form_open('contact', array('id' => 'contactForm', 'class' => 'form-horizontal')); ?>
	<?php if(isset($success) && $success): ?>
		<div class="alert alert-success"><a class="close" data-dismiss="alert">&times;</a><?php echo $this->lang->line('form.contact.success'); ?></div>
	<?php elseif(validation_errors()): ?>
		<div class="alert alert-error"><a class="close" data-dismiss="alert">&times;</a><?php echo $this->lang->line('form.contact.error'); ?></div>
	<?php endif; ?>
	<fieldset>
		<legend><?php echo $this->lang->line('form.contact.legend'); ?></legend>
		
		<div class="control-group<?php echo (form_error('name'))?' error':null; ?>">
			<label class="control-label" for="name"><?php echo $this->lang->line('form.contact.name.label'); ?></label>
			<div class="controls">
				<input type="text" class="span4" name="name" placeholder="<?php echo $this->lang->line('form.contact.name.placeholder'); ?>" id="name" />
				<?php echo form_error('name', '<span class="help-inline">', '</span>'); ?>
			</div>
		</div>
		
		<div class="control-group<?php echo (form_error('email'))?' error':null; ?>">
			<label class="control-label" for="email"><?php echo $this->lang->line('form.contact.email.label'); ?></label>
			<div class="controls">
				<input type="text" class="span4" name="email" placeholder="<?php echo $this->lang->line('form.contact.email.placeholder'); ?>" id="email" />
				<?php echo form_error('email', '<span class="help-inline">', '</span>'); ?>
			</div>
		</div>
		
		<div class="control-group<?php echo (form_error('subject'))?' error':null; ?>">
			<label class="control-label" for="subject"><?php echo $this->lang->line('form.contact.subject.label'); ?></label>
			<div class="controls">
				<select name="subject" class="span4" id="subject">
					<option value="feedback"><?php echo $this->lang->line('form.contact.subject.feedback'); ?></option>
					<option value="enquiry"><?php echo $this->lang->line('form.contact.subject.enquiry'); ?></option>
					<option value="problem"><?php echo $this->lang->line('form.contact.subject.problem'); ?></option>
				</select>
				<?php echo form_error('subject', '<span class="help-inline">', '</span>'); ?>
			</div>
		</div>
		
		<div class="control-group<?php echo (form_error('message'))?' error':null; ?>">
			<label class="control-label" for="message"><?php echo $this->lang->line('form.contact.message.label'); ?></label>
			<div class="controls">
				<textarea name="message" class="span4" id="message" cols="30" rows="10" placeholder="<?php echo $this->lang->line('form.contact.messege.placeholder'); ?>"></textarea>
				<?php echo form_error('message', '<span class="help-inline">', '</span>'); ?>
			</div>
		</div>
		
		<div class="control-group<?php echo (form_error('privacy'))?' error':null; ?>">
			<label for="privacy" class="control-label"><?php echo $this->lang->line('form.contact.privacy.label'); ?></label>
			<div class="controls">
				<label for="privacy" class="checkbox">
					<input type="checkbox" id="privacy" name="privacy" value="true" />
					<?php echo $this->lang->line('form.contact.privacy.statement'); ?>
					<?php echo form_error('privacy', '<p class="help-block">', '</p>'); ?>
				</label>
			</div>
		</div>
		
		<div class="form-actions">
			<button type="submit" class="btn btn-primary"><?php echo $this->lang->line('form.contact.submit'); ?></button>
			<button type="reset" class="btn"><?php echo $this->lang->line('form.contact.reset'); ?></button>
		</div>
	</fieldset>
</form>