<?php
// ./application/view/userPanel/password.php

/**
 * Contains the view for allowing a user to change their password
 * @author Steve "Uru" West <uru@mozhunt.com>
 * @version 2012-01-30
 */

echo validation_errors();

echo form_open('userPanel/password');
?>
	Current Password:<input type="password" name="cpw" /><br />
	New Password:<input type="password" name="cp1" /><br />
	Re-Enter Password:<input type="password" name="cp2" /><br />
</form>
<?
// End of file password.php
