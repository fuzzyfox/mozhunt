<?php echo form_open('token/create/'.$domainID, array('class'=>'form-horizontal')); ?>
	<fieldset>
		<legend>Create token</legend>
		<div class="control-group<?php echo (form_error('name'))?' error':null; ?>">
			<label for="name" class="control-label">Name of Token</label>
			<div class="controls">
				<input type="text" name="name" value="<?php echo set_value('name');?>"/>
				<?php echo form_error('domain', '<span class="help-inline">', '</span>'); ?>
				<p class="help-block">This is a name for the token that only you will
				see... it is to help you identify which tokens you have created are which.</p>
			</div>
		</div>
		<div class="control-group<?php echo (form_error('clue'))?' error':null; ?>">
			<label for="clue" class="control-label">Clue</label>
			<div class="controls">
				<textarea name="clue" id="clue" maxlength="140" class="input-xlarge"><?php echo set_value('clue');?></textarea>
				<?php echo form_error('domain', '<span class="help-inline">', '</span>'); ?>
				<p class="help-block">This is a maximum of 140 characters and provides
				a slight hint to players as to where you token is hidden. (e.g. <em>Is it
				just us or is there a sleeping panda on our site?</em>)</p>
			</div>
		</div>
		<div class="form-actions">
			<button type="submit" class="btn btn-primary">Create</button>
			<a href="domain/view/<?php echo $domainID; ?>" class="btn">Cancel</a>
		</div>
	</fieldset>
</form>