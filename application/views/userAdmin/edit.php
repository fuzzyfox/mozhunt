<?php
// ./application/view/userAdmin/edit.php

/**
 * The view for user editing
 * @author Steve "Uru" West <uru@mozhunt.com>
 * @version 2012-02-06
 */

echo validation_errors();

echo form_open('userAdmin/edit/'.$userID);
?>
	Nickname: <input type="text" name="newname" value="<?= $nickname; ?>" /><br />
	Email: <input type="text" name="email" value="<?= $email; ?>" /><br />
	Password: <input type="password" name="pw1" /><br />
	Re-enter password: <input type="password" name="pw2" /></br>

	<input type="submit" name="submit" value="Update" />
</form>
<?
// End of file edit.php
