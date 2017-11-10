<?php
function display_login_form()
{
?>
<div id="login_form">
<form method=post action="../../loggedin_test.php">
<ul>
<li>Username:<input name=username type=text size="16" maxlength="25"></li>
<li>Password:<input type=password name=passwd size="16" maxlength="25"></li>
<input type=submit value="Log in">
</ul>
</form>
</div>
<?php
}
?>

