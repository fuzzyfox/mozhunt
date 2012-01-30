<?php
// ./application/view/userPanel/nickname.php

/**
 * The form to allow users to change their nickname
 * @author Steve "Uru" West <uru@mozhunt.com>
 * @version 2012-01-28
 */

echo validation_errors();

echo form_open('userPanel/nickname');
?>
	Nickname: <input type="text" name="newname" value="<?php $nickname; ?>" /><br />
	<input type="submit" name="submit" value="Save" />
</form>
<?php
// End of file: nickname.php
