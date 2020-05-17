<section class="mb-3 mb-sm-4 mb-md-6">
	@php
	if ( function_exists('yoast_breadcrumb') ) {
	  yoast_breadcrumb( '<nav aria-label="breadcrumb" class="breadcrumb light">','</nav>' );
	}
	@endphp
	<div class="breadcrumbs" typeof="BreadcrumbList" vocab="https://schema.org/">
	  @if ( function_exists( 'bcn_display' ) )
		  {!!  bcn_display() !!}
	  @endif
  </div>
</section>