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
		@endphp
		@if ( count( $child_object ) )
			<section class="service-detail">
				<div class="tab-collapse">
					<div class="row row-cols-2">
						<div class="col-12 col-md-4">
							<div class="nav m-0">
								@foreach ( $child_object as $key => $obj )
									@if ( $key === 0 )
										<a class="nav-link w-100 active">
											<strong>{{ $object->name }}</strong> @php echo $object->count ? '('.$object->count.')' : '' @endphp
										</a>
									@endif
									<a class="nav-link w-100" href="{{ get_term_link( $obj->term_id ) }}">
										<i class="icofont-minus"></i> {{ $obj->name }} @php echo $obj->count ? '('.$obj->count.')' : '' @endphp
									</a>
								@endforeach								
							</div>
						</div>
						<div class="col-12 col-md">
							<div class="tab-content">
								@foreach ( $child_object as $key => $obj )
									@if ( $key === 0 )
										<div class="tab-pane fade active show">
											<div class="collapse-title">
												<button class="btn btn-link btn-block " type="button">
													<strong>{{ $object->name }}</strong> @php echo $object->count ? '('.$object->count.')' : '' @endphp
												</button>
											</div>
											<div class="collapse show">
												<div class="collapse-body">
													<section>
														<div class="block-list">
															@while(have_posts()) @php the_post() @endphp
																@include('partials.content-'.get_post_type())
															@endwhile
														</div>
													</section>
													@include('partials.paginate-link')
												</div>
											</div>
										</div>
									@endif
									<div class="tab-pane fade">
										<div class="collapse-title">
											<a href="{{ get_term_link( $obj->term_id ) }}">
												<button class="btn btn-link btn-block collapsed" type="button">
													<i class="icofont-minus"></i> {{ $obj->name }} @php echo $obj->count ? '('.$obj->count.')' : '' @endphp
												</button>
											</a>
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
