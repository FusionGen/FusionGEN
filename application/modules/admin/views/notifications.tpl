<ul>
{foreach from=$notifications item=notification}
	<li>
		<a href="javascript:void(0)">
			<span class="title {if !$notification.read}fw-bold{/if}" onClick="Notify.markRead({$notification.id}, this)">{$notification.title}</span>
			<span class="message">{date("Y-m-d H:i:s", $notification.time)}</span>
		</a>
	</li>
{/foreach}
</ul>
<hr>

<div class="text-end">
	<a href="javascript:void(0)" onClick="Notify.markAllRead()" class="view-more">Mark all read</a>
</div>
