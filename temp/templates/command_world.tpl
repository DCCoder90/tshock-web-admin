{include file='inc/header.tpl'}

<form action="{$url}/command_world.php" method="get">
<input type="hidden" name="sid" value="">
<table>
<tr>
	<td><input type="radio" name="cmd" value="read">Read</td>
	<td><input type="radio" name="cmd" value="meteor">Summon Meteor</td>
	<td><input type="radio" name="cmd" value="bloodmoon">Summon BloodMoon</td>
	<td><input type="radio" name="cmd" value="save">Save World</td>
</tr>
<tr>
	<td colspan="2"><input type="radio" name="cmd" value="autosave">AutoSave<br />
		<select name="as">
			<option value="1">On</option>
			<option value="0">Off</option>
		</select>
	</td>
	<td colspan="2"><input type="radio" name="cmd" value="butcher">Butcher<br />
		Kill Friendly? <select name="kf">
							<option value="1">On</option>
							<option value="0">Off</option>
					   </select>
	</td>
</tr>
</table><br /><br />

<input type="submit" value="Execute!" />
</form>
<br /><br />

{if $response neq ""}
	<div id="response">
		{$response}
	</div>
{/if}
{include file='inc/footer.tpl'}