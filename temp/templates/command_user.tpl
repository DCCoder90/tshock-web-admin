{include file='inc/header.tpl'}

<form action="{$url}/command_user.php" method="get">
<input type="hidden" name="sid" value="">

User: <input type="text" name="usr" /><br />
Password: <input type="text" name="pas" /><br />
Group: <input type="text" name="grp" /><br />
Action: <select name="cmd">
			<option value="read">Read</option>
			<option value="destroy">Delete</option>
			<option value="update">Update</option>
			<option value="bancreate">Ban</option>
			<option value="activelist">View Active List</option>
		</select><br />

<input type="submit" value="Execute!">
</form>
<br /><br />

{if $response neq ""}
	<div id="response">
		{$response}
	</div>
{/if}
{include file='inc/footer.tpl'}