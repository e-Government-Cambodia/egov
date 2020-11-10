@extends('layouts.app')

@section('content')
	<div class="container">
		@include('partials.search')
		@include('partials.page-header')
		@include('partials.breadcrumbs-egov')
		
		@if (!have_posts())
			<div class="alert alert-warning">
				{{ __('Sorry, no results were found.', 'egov') }}
			</div>
		@endif

		@php
			$object = get_queried_object();
			$child_object = get_terms( array(
				'taxonomy' => $object->taxonomy,
				'hide_empty' => true,
				'parent' => $object->term_id
			) ) ;
			// print_r($object);
			// echo ( get_term_link( $object->term_id ) )
			$thumbnail = get_term_meta( $object->term_id, 'egov_service_topic_thumbnail', true );
		@endphp
		
		@if ( $thumbnail )
			
		<section class="wp-block-egov-block-hero-banner"><figure class="hero-banner"><div class="aspectratio-4-1"><div class="img blend" style="background-image:url( {{ $thumbnail }} );background-color:rgba(0, 0, 0, 0.55)"></div></div><figcaption class="hero-content d-flex"><div class="my-auto"><h2 class="hero-title">{{ $object->description }}</h2></div></figcaption></figure></section>
			
		@endif

		@if ( count( $child_object ) )
			<section class="service-detail">
				<div class="tab-collapse">
					<div class="row row-cols-2">
						<div class="col-12 col-md-4">
							<div id="tab-collapse" role="tablist" aria-orientation="vertical" class="nav m-0">
								@foreach ( $child_object as $key => $obj )
									<a id="tab-collapse-{{ $obj->term_id }}" data-toggle="pill" href="#tab-{{ $obj->term_id }}" aria-controls="tab-{{ $obj->term_id }}" aria-selected="{{ $key === 0 ? 'true' : 'false' }}" class="nav-link w-100 {{ $key === 0 ? 'active' : '' }}">
										<strong>{{ $obj->name }}</strong> @php echo $obj->count ? '('.$obj->count.')' : '' @endphp
									</a>
								@endforeach								
							</div>
						</div>
						<div class="col-12 col-md">
							<div class="tab-content" id="accordion-tab-collapse">
								@foreach ( $child_object as $key => $obj )
									<div id="tab-{{ $obj->term_id }}" role="tabpanel" aria-labelledby="tab-collapse-{{ $obj->term_id }}" class="tab-pane fade {{ $key === 0 ? 'active show' : '' }}">
										<div id="heading-{{ $obj->term_id }}" class="collapse-title">
											<button data-toggle="collapse" data-tab="#tab-{{ $obj->term_id }}" data-target="#collapse-tab-{{ $obj->term_id }}" aria-expanded="{{ $key === 0 ? 'true' : 'false' }}" aria-controls="collapse-tab-{{ $obj->term_id }}" class="btn btn-link btn-block {{ $key === 0 ? '' : 'collapsed' }}" type="button">
												<strong>{{ $obj->name }}</strong> @php echo $obj->count ? '('.$obj->count.')' : '' @endphp
											</button>
										</div>
										<div id="collapse-tab-{{ $obj->term_id }}" aria-labelledby="heading-{{ $obj->term_id }}" data-parent="#accordion-tab-collapse" class="collapse {{ $key === 0 ? 'show' : '' }}">
											<div class="collapse-body">
												<section>
													<div class="block-list">
														@php
															$subterm = get_terms( array(
																'taxonomy' => $obj->taxonomy,
																'hide_empty' => true,
																'parent' => $obj->term_id
															) ) ;
														@endphp
														@if ( count( $subterm ) )
															<div class="col">
																<article class="wrap-item">
																	@foreach ( $subterm as $term )
																		<a class="text-light p-1 bg-primary" href="{{ get_term_link( $obj->term_id ) }}#tab-{{ $term->term_id }}">{{ $term->name }}</a>
																	@endforeach
																</article>
															</div>
														@endif
														@php
															$args = array(
																'post_type' => 'service',
																'tax_query' => array(
																	array(
																		'taxonomy' => 'service-topic',
																		'field'    => 'slug',
																		'terms'    => $obj->slug,
																	)
																),
																'posts_per_page' => -1
															);
															$query = new WP_Query( $args );
														@endphp
														@if ( $query->have_posts() )
															@while ( $query->have_posts() )
																@php $query->the_post() @endphp
																@include('partials.content-'.get_post_type())
															@endwhile
														@endif
														@php wp_reset_postdata() @endphp
													</div>
												</section>
											</div>
										</div>
									</div>
								@endforeach	
							</div>
						</div>
					</div>
				</div>
			</section>
		@else
			<div class="block-list">
				<div class="row row-cols-1">
					@while(have_posts()) @php the_post() @endphp
						@include('partials.content-'.get_post_type())
					@endwhile
				</div>
			</div>
			@include('partials.paginate-link')
		@endif

	</div>
@endsection
