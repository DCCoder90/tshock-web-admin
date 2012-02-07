</div>
<div id="right_content">
<div id="server_status">
<!--Server status and selection goes here-->

<ol class="server_list">
{foreach from=$servers item=server}
	<li id="{$server.id}" class="ui-widget-content"><img src="{$url}/images/serverstatus.php?name={$server.name}&status={$server.status}&port={$server.port}&playercount={$server.playercount}" alt="{$server.name}" /></li>
{/foreach}
</ol>

</div>
<div id="alerts">
<!--Major alerts/erros go here -->
{foreach from=$alerts item=alert}
<div class="alerts">
	<span class="alert_time">{$alert.log_date}</span>&nbsp;-&nbsp;
	<span class="alert_server">{$alert.server_id}</span>&nbsp;-&nbsp;
	<span class="alert_text">{$alert.log_info}&nbsp;{$alert.log_misc}</span>
</div>
{/foreach}
</div>
</div>
<div id="copyright">&copy; Powered by TShock Web Admin by Darkvengance</div>
</body>
</html>