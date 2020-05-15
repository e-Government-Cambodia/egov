@php
	global $post;	
	$args = array(
		'post_type' => $post->post_type,
		'post__not_in' => array( $post->ID ),
		'posts_per_page' => 6,
		'tax_query' => array(
			array(
				'taxonomy' => 'service-type',
				'field'    => 'slug',
				'terms'    => App::getPostTerms(),
			),
		),
	);
	$query = new WP_Query( $args );	
@endphp
@if ( $query->have_posts() )
	<section class="mb-3 mb-sm-4 mb-md-6 mt-6">
		<header class="block-heading text-left">
			<h4 class="text-danger font-weight-bold">
				{{ __( 'Related Service', 'egov' ) }}
			</h4>
		</header>
		<div class="row row-cols-1 row-cols-sm-2 row-cols-md-3">
			@while ( $query->have_posts() )
				@php $query->the_post() @endphp
				<div class="col mb-3">
					<i class="icofont-thin-right"></i> <a href="{!! get_the_permalink() !!}">{!! get_the_title() !!}</a>
				</div>
			@endwhile
		</div>
	</section>
@endif
@php
	wp_reset_postdata()
@endphp