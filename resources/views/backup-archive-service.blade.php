@extends('layouts.app')

@section('content')
	<div class="container">
		@include('partials.search')
	</div>
	<div class="container-fluid">
		@php
			$terms = get_terms( array(
				'taxonomy' => 'service-topic',
				'hide_empty' => false,
				'parent' => 0
			) ) ;
		@endphp
		@if ( count( $terms ) )
			<header class="wp-block-egov-block-block-title block-heading text-center"><h4>{{ __( 'TOPICS', 'egov' ) }}</h4></header>
			<div class="block-topic">
				<table class="table table-bordered ">
					<tbody>
						<tr>
							@foreach ( $terms as $key => $value )
								<td>
									<article>
										<figure class="d-lg-flex">
											@if ( get_term_meta( $value->term_id, 'egov_service_topic_icon', true ) )
												<div class="mr-lg-2">
													<img width="34" src="{{ get_term_meta( $value->term_id, 'egov_service_topic_icon', true ) }}">
												</div>
											@endif
											<figcaption>
												<a href="{{ get_term_link( $value->term_id ) }}">
													<h5>{{ $value->name }}</h5>
												</a>
												<p class="d-none d-lg-block">{{ $value->description }}</p>
											</figcaption>
										</figure>
									</article>
								</td>
								@if ( ( ( $key + 1 ) % 3 ) == 0 )
									</tr>
									<tr>
								@endif
							@endforeach
						</tr>
					</tbody>
				</table>
			</div>
		@endif
		@php
			$terms = get_terms( array(
				'taxonomy' => 'service-for',
				'hide_empty' => false,
				'parent' => 0
			) ) ;
		@endphp
		@if ( count( $terms ) )
			<header class="wp-block-egov-block-block-title block-heading text-center"><h4>{{ __( 'SERVICE FOR', 'egov' ) }}</h4></header>
			<div class="block-topic">
				<table class="table table-bordered ">
					<tbody>
						<tr>
							@foreach ( $terms as $key => $value )
								<td>
									<article>
										<figure class="d-lg-flex">
											@if ( get_term_meta( $value->term_id, 'egov_service_topic_icon', true ) )
												<div class="mr-lg-2">
													<img width="34" src="{{ get_term_meta( $value->term_id, 'egov_service_topic_icon', true ) }}">
												</div>
											@endif
											<figcaption>
												<a href="{{ get_term_link( $value->term_id ) }}">
													<h5>{{ $value->name }}</h5>
												</a>
												<p class="d-none d-lg-block">{{ $value->description }}</p>
											</figcaption>
										</figure>
									</article>
								</td>
								@if ( ( ( $key + 1 ) % 3 ) == 0 )
									</tr>
									<tr>
								@endif
							@endforeach
						</tr>
					</tbody>
				</table>
			</div>
		@endif
	</div>
	@php
		$terms = get_terms( array(
			'taxonomy' => 'service-i-want-to',
			'hide_empty' => false,
			'parent' => 0
		) ) ;
	@endphp
	@if ( count( $terms ) )
		<section class="block-i-want-to mb-1">
			<div class="row">
				<div class="col-4 my-auto text-center">
					<h4 class="block-title"><b>{{ __( 'I WANT TO...', 'egov' ) }}</b></h4>
				</div>
				<div class="col">
					<ul class="row row-cols-1 row-cols-md-2">
						@foreach ( $terms as $key => $value )
							<li class="wp-block-egov-block-link-iii-item"><a href="{{ get_term_link( $value->term_id ) }}">{{ $value->name }}</a></li>
						@endforeach
					</ul>
				</div>

			</div>
		</section>
		{{-- <div class="container-fluid">
			<div style="border-bottom:1px solid #ddd; margin-top:-1px;"></div>
		</div> --}}
	@endif
@endsection
