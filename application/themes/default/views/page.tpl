<article class="box">
	<h2 class="head">{$headline}</h2>
	<section class="body">
		{$content}
	</section>
</article>

<script type="text/javascript">
	$('.expandable > .head').on('click', function() {
		var parent = $(this).parent();
		parent.toggleClass('collapsed').find('> .body').slideToggle();
		setCookie(parent.prop('id'), parent.hasClass('collapsed') ? 1 : 0, 7);
	});
	
	$('.closeable > .close-btn').on('click', function() {
		var parent = $(this).parent();
		parent.toggleClass('closed').fadeToggle(0);
		setCookie(parent.prop('id'), parent.hasClass('closed') ? 1 : 0, 7);
	});
	
	$(function() {
		$('.expandable').each(function() {
			var element = $(this),
				collapsed = element.hasClass('collapsed'),
				cookie = getCookie(element.prop('id')) == 1;
			if((cookie && !collapsed) || (!cookie && collapsed))
				element.find('> .head').trigger('click');
		});
		
		$('.closeable').each(function() {
			var element = $(this),
				closed = element.hasClass('closed'),
				cookie = getCookie(element.prop('id')) == 1;
			if(!element.find('> .close-btn').length)
				element.prepend('<a href="javascript:void(0)" class="close-btn"></a>');
			if((cookie && !closed) || (!cookie && closed))
				element.find('> .close-btn').trigger('click');
		});
	});
</script>