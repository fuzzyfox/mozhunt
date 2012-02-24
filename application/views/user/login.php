<?php
// ./application/views/user/login.php

/**
 * Contains the log in form
 * @author Steve "Uru" West <uru@mozhunt.com>
 * @version 2012-01-23
 */

echo validation_errors();

echo form_open('user/login');
?>

	Email: <input type="text" name="email" value="<?php echo set_value('email'); ?>" /><br />
	Password: <input type="password" name="password" /><br />
	<input type="submit" name="submit" value="Login" />
</form>
<?php
// End of file login.php
