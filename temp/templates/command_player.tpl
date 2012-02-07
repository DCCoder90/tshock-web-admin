{include file='inc/header.tpl'}

<form action="{$url}/command_player.php" method="get">
<input type="hidden" name="sid" value="">

Player: <input type="text" name="usr" /><br />
Action: <select name="cmd">
			<option value="read">Read</option>
			<option value="kick">Kick</option>
			<option value="ban">Ban</option>
			<option value="kill">Kill</option>
			<option value="mute">Mute</option>
			<option value="unmute">Unmute</option>
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