<?php echo form_open('contact/process', array('id' => 'contactForm')); ?>
	<label for="name"><?php echo $this->lang->line('form.contact.name.label'); ?></label>
	<input type="text" name="name" placeholder="<?php echo $this->lang->line('form.contact.name.placeholder'); ?>" id="name" />
	
	<label for="email"><?php echo $this->lang->line('form.contact.email.label'); ?></label>
	<input type="text" name="email" placeholder="<?php echo $this->lang->line('form.contact.email.placeholder'); ?>" id="email" />
	
	<label for="subject"><?php echo $this->lang->line('form.contact.subject.label'); ?></label>
	<select name="subject" id="subject">
		<option value="feedback"><?php echo $this->lang->line('form.contact.subject.feedback'); ?></option>
		<option value="enquiry"><?php echo $this->lang->line('form.contact.subject.enquiry'); ?></option>
		<option value="problem"><?php echo $this->lang->line('form.contact.subject.problem'); ?></option>
	</select>
	<label for="message"><?php echo $this->lang->line('form.contact.messege.label'); ?></label>
	<textarea name="message" id="message" cols="30" rows="10" placeholder="<?php echo $this->lang->line('form.contact.messege.placeholder'); ?>"></textarea>
	<button type="submit" name="submit" id="submit"><?php echo $this->lang->line('form.contact.submit'); ?></button>
</form>