{include file='inc/header.tpl'}

<center>
<form action="{$url}/servers.php" method="post">
<input type="hidden" name="serverid" value="{$svr.id}" />
Are you sure you want to delete server {$svr.name}?
<input type="submit" name="delete" value="Yes" />
</form>
</center>

{include file='inc/footer.tpl'}