<?php echo form_open('domain/delete/'.$domainID, array('class'=>'form-horizontal')); ?>
	<div class="alert alert-block">
		<h4 class="alert-heading">Warning!</h4>
		You are about to remove the domain <?php echo $url; ?> from the system, mozhunt
		will assume ownership of this domain in the system to ensure continuity of scores for those
		playing the game. We will remove all links between this domain and your account.
		<h4>THIS CANNOT BE UNDONE!</h4>
		Please ensure that you have the right domain before clicking the Delete
		button.
	</div>
	<div class="form-actions">
		<button type="submit" name="submit" value="true" class="btn btn-danger">Delete</button>
		<a href="domain" class="btn">Cancel</a>
	</div>
</form>