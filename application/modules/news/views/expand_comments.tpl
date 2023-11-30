{if $article.comments != -1}
	<script>
		$(document).ready(function()
		{
			function checkIfLoaded()
			{
				if(typeof Ajax != "undefined")
				{
					Ajax.showComments({$article.id});
				}
				else
				{
					setTimeout(checkIfLoaded, 50);
				}
			}

			checkIfLoaded();
		});
	</script>
{/if}
