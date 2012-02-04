{include file='inc/header.tpl'}

<form action="{$url/command_server.php" method="get">
<input type="hidden" name="sid" value="">
<table>
<tr>
	<td colspan="2"><input type="radio" name="cmd" value="status">Status</td>
	<td colspan="2"><input type="radio" name="cmd" value="cast">Broadcast<br />
		<textarea name="msg"></textarea>
	</td>
</tr>
<tr>
	<td colspan="2"><input type="radio" name="cmd" value="autosave">Raw Command<br />
		<textarea name="rawcmd"></textarea>
	</td>
	<td colspan="2"><input type="radio" name="cmd" value="off"><font color="red">Shutdown</font></td>
</tr>
</table>
</form>
<br /><br />

{if $response neq ""}
	<div id="response">
		{$response}
	</div>
{/if}
{include file='inc/footer.tpl'}