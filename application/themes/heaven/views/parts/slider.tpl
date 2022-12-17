<!-- Slider Section.Start -->
<section class="section section-wall" wall>
	<div class="container d-flex flex-grow-1 align-items-center justify-content-center">
		<div class="row w-100 justify-content-center">
			<div class="col-sm-12">
				<div class="wall-slider owl-carousel owl-theme" owl-carousel="main">
					{foreach from=$slider item=slide}
					<div class="slider-item set-bg">
						<div class="container">
							{if $slide.header}<div class="item-title">{$slide.header}</div>{/if}
							{if $slide.body}<div class="item-desc">{$slide.body}</div>{/if}
							{if $slide.footer}<div class="slider-footer mt-5">{$slide.footer}</div>{/if}
							<a href="#" class="btn-blue -round text-ellipsis" title="Read more">Read more</a>
						</div>
					</div>
					{/foreach}
				</div>
			</div>
					
			<div class="col-sm-12 mt-5">
				<div class="wall-online" title="Players online 1538">Players online <span>1538</span></div>
			</div>
			
			<div class="col-sm-12 mt-5">
				<div class="wall-membership">
					<a href="#" class="btn-big text-ellipsis" title="Play now"><span>Play now</span></a>
					<div class="membership-row mt-3">Already a member? <a href="#">LOGIN</a> or</div>
					<div class="membership-row mt-3"><a href="#" class="btn-blue -outline -noise text-ellipsis" title="Register">Register</a></div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Slider Section.End -->

