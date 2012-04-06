<?php echo form_open('domain/create', array('class'=>'form-horizontal')); ?>
	<fieldset>
		<legend>Create domain</legend>
		<div class="control-group<?php echo (form_error('domain'))?' error':null; ?>">
			<label for="domain" class="control-label">Domain</label>
			<div class="controls">
				<input type="text" name="domain" value="<?php echo set_value('domain'); ?>" placeholder="www.example.com"/>
				<?php echo form_error('domain', '<span class="help-inline">', '</span>'); ?>
				<p class="help-block">The domain should be the address users need
				to enter to visit the homepage of your site. If the site is a subdomain
				you intend to hide tokens on is a subdomain then please enter that
				address.<br>
				Please do <strong>not</strong> include a trailing slash <strong>or</strong>
				the protocol (e.g. <code>http://</code>, <code>https://</code>)</p>
			</div>
			<div class="form-actions">
				<button type="submit" class="btn btn-primary">Create</button>
				<a href="domain" class="btn">Cancel</a>
			</div>
		</div>
	</fieldset>
</form>