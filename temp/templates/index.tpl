{include file='inc/fake/header.tpl'}

<center>
<img src="{$url}/images/tshocklogo.png"><br />
<div id="loginbox">
<form action="{$url}/action.php?act=login" method="post">
Username: <input type="text" name="user" id="username" value="" /><br />
Password: <input type="password" name="pass" id="password" value="" /><br />
<input type="submit" name="submit" id="loginbutton" value="Login!" />
</form>
</div>
</center>

{include file='inc/fake/footer.tpl'}