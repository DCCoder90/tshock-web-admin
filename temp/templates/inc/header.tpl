<html>
<head>
	<title>{$site_title}</title>
	<link rel="stylesheet" type="text/css" href="{$url}/css/default.css" />
	<meta name="description" content="{$meta_desc}" />
	<meta name="keywords" content="{$meta_keywords}" />
	<meta name="author" content="Sildaekar aka Darkvengance" />
	<link rel="icon" type="image/png" href="{$url}/favicon.ico" />
	<script language="javascript" type="text/javascript" src="{$url}/inc/javascript/jquery/jquery.js">
	</script>

	<!--Select function -->
	<script language="javascript" type="text/javascript">
	$(function() {
		$( "#server_list" ).selectable({
			stop: function() {
				var result = $( "#select-result" ).empty();
				$( ".ui-selected", this ).each(function() {
					var index = $( "#selectable li" ).index( this );
					result.append( " #" + ( index + 1 ) );
				});
			}
		});
	});
	</script>
	<!--End select function-->

	<!--Resize function -->
	<script language="javascript" type="text/javascript">
	$(function() {
		$( "#server_status" ).resizable({
			maxHeight: 250,
			maxWidth: 350,
			minHeight: 150,
			minWidth: 200
		});
	});
	</script>
	<!--End resize function -->
</head>
<body>

<div id="left_content">
{if $navigate eq 1}
	{include file='inc/navigation.tpl'}
{/if}
</div>
<div id="body_content">