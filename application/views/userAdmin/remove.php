<?
// ./application/views/userAdmin/remove.php

/**
 * Shows a button to double check a user wants to be deleted
 * @author Steve "Uru" West <uru@mozhunt.com>
 * @version 2012-02-06
 */

echo validation_errors();

echo form_open('userAdmin/remove/'.$badID);
?>
	You are about to delete:<br />
	<?= $nickname; ?>, <?= $email; ?><br /><br />
	Are you sure you want to do this? It cannot be undone!<br />
	<input type="submit" name="submit" value="Delete" />
</form>
<?
// End of file remove.php
