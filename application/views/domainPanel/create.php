<?php
$this->load->helper('form');
?>
<?php
echo form_open('domain/create');
echo form_label('Domain name', 'domain');
echo form_input('domain');
?>
<p>This domain name is what all tokens must appear under, so make sure you choose wisely!</p>
<?php 
echo form_sumbit();
echo form_close();
?>