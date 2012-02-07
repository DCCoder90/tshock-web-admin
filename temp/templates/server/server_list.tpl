{include file='inc/header.tpl'}

<u>Please choose what you want to do:</u><br />

<form action="{$url}/servers.php" method="post">
<input type="hidden" name="sid" value="" />
<select name="action">
<option value="add">Add Server</option>
<option value="edit">Edit Server</option>
<option value="del">Delete Server</option>
</select>&nbsp;&nbsp;<input type="submit" value="Execute!" />
</form>

{include file='inc/footer.tpl'}