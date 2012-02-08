{include file='inc/header.tpl'}

<form action="{$url}/servers.php" method="post" id="validateform">
<input type="hidden" name="act" value="add" />

<b>Server Info:</b><br />

Server Name: <input type="text" name="name" class="required"/><br />
Server IP Address: <input type="text" name="ip" class="required" /><br />
Server Port: <input type="text" name="port" class="required"/><br />
RestAPI Port: <input type="text" name="restport" class="required"/><br /><br />

<b>SuperAdmin Info:</b><br />
Username: <input type="text" name="user" class="required"/><br />
Password: <input type="text" name="pass" class="required"/><br /><br />

<b>Log Info:</b><br />
Log Access: <select name="ltype">
				<option value="2">No Access</option>
				<option value="0">Local Log</option>
				<option value="1">FTP Access</option>
			</select><br />
TShock Version: <select name="lname">
					<option value="1">&gt;3.7.0.0</option>
					<option value="0">&lt;3.7.0.0</option>
				</select><br /><br />

<b>FTP Settings:</b><br />
Username: <input type="text" name="ftpu" /><br />
Password: <input type="text" name="ftpp" /><br />
FTP Port: <input type="text" name="ftpo" value="21" /><br /><br />

<input type="submit" name="submit" value="Add Server" />
</form>

{include file='inc/footer.tpl'}