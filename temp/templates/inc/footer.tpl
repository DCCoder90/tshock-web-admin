</div>
<div id="right_content">
<div id="server_status">
<ul id="server_list">
{foreach from=$servers item=server}
	<li><img src="{$url}/images/serverstatus.php?name={$server.name}&status={$server.status}&port={$server.port}&playercount={$server.playercount}" alt="{$server.name}" /></li>
{/foreach}
<!--Server status and selection goes here-->
</ul>
</div>
<div id="alerts">
<!--Major alerts/erros go here -->
</div>
</div>
<div id="copyright">&copy; Powered by TShock Web Admin by Darkvengance</div>
</body>
</html>