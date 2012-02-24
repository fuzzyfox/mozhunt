<?php
// ./application/view/user/create.php

/**
 * The view for user registration/creation
 * @author Steve "Uru" West <uru@mozhunt.com>
 * @version 2012-01-21
 */

echo validation_errors();

echo form_open('user/create');
?>
	Nickname: <input type="text" name="nickname" value="<?php echo set_value('nickname'); ?>" /><br />
	Email: <input type="text" name="email" value="<?php echo set_value('email'); ?>" /><br />
	Password: <input type="password" name="pw1" /><br />
	Re-enter password: <input type="password" name="pw2" /></br>

	<input type="submit" name="submit" value="Register" />
</form>
<?
// End of file create.php
