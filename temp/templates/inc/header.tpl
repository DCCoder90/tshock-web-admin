<html>
<head>
	<title>{$site_title}</title>
	<link rel="stylesheet" type="text/css" href="{$url}/css/default.css" />
	<meta name="description" content="{$meta_desc}" />
	<meta name="keywords" content="{$meta_keywords}" />
	<meta name="author" content="Sildaekar aka Darkvengance" />
	<link rel="icon" type="image/png" href="{$url}/favicon.ico" />
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
		google.load("jquery", "1.7.1");
		google.load("jqueryui", "1.8.16");
	</script>
	<script type="text/javascript" src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js"></script>
	<script type="text/javascript" src="{$url}/inc/javascript/common.js"></script>
</head>
<body>

<div id="left_content">
	<div id="nav">
		{if $navigate eq 1}
			{include file='inc/navigation.tpl'}
		{/if}
	</div>
	<div id="quick_broadcast">
		<input type="hidden" name="sid" value="0" />
		<textarea id="quickmsg" cols="15" rows="3"></textarea>
		<input type="submit" name="submit" id="quickbrdcst" value="Broadcast!">
	</div>
	{if $message neq ""}
	<div id="feedback">
		{$message}
	</div>
	{/if}
</div>
<div id="body_content">