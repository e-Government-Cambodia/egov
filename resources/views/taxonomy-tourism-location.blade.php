@extends('layouts.app')

@section('content')
	<div class="container">
		@include('partials.search')
		@include('partials.page-header')
		{{-- @include('partials.breadcrumbs-egov') --}}

		

		@php
			$object = get_queried_object();
			$location_terms = get_terms( array(
				'taxonomy' => 'tourism-location',
				'hide_empty' => false,
				'parent' => 0
			) ) ;
			$type_terms = get_terms( array(
				'taxonomy' => 'tourism-type',
				'hide_empty' => false,
				'parent' => 0
			) ) ;
		@endphp

		{{-- @dump($location_terms) --}}
		{{-- @dump($object) --}}

		<form class="mb-md-6 mb-sm-4 mb-3 form-filter">
			<div class="d-sm-flex">
				<div class="d-flex">
					<h4 class="m-sm-auto mb-3 font-weight-bold">
						<label class="mb-0 mr-sm-6" for="inlineFormCustomSelectPref">{{ __( 'Discovered by', 'egov' ) }}</label>
					</h4>
				</div>
				<div class="flex-sm-fill">
					<div class="p-4 select">
						<select class="custom-select custom-select-lg" id="inlineFormCustomSelectPref" onchange="location = this.value;">							
							<option value="#">
								{{ __( 'Please Select', 'egov' ) }}
							</option>
							@foreach ( $location_terms as $key => $term )
								
								@if ( $object->term_id == $term->term_id )
									<option selected value="{{ get_term_link( $term->term_id ) }}">
										{{ $term->name }} ({{ $term->count }})
									</option>
								@else
									<option value="{{ get_term_link( $term->term_id ) }}">
										{{ $term->name }} ({{ $term->count }})
									</option>
								@endif
							@endforeach

						</select>
					</div>

				</div>
			</div>
		</form>

		<div class="d-md-flex tab-collapse">
                    
			<div class="nav flex-column" role="tablist" aria-orientation="vertical">

				@foreach ( $type_terms as $key => $term )
					<a class="nav-link" href="{{ get_term_link( $term->term_id ) }}" aria-selected="false">
						{{ $term->name }} ({{ $term->count }})
					</a>
				@endforeach

			</div>

			<div class="flex-fill tab-content tab-content">
				@foreach ( $location_terms as $key => $term )
					@if ( $object->term_id == $term->term_id )  
						<div class="tab-pane fade show active" role="tabpanel">
							<div class="collapse-title">
								<button class="btn btn-link btn-block" type="button">
									{{ $term->name }} ({{ $term->count }})
								</button>
							</div>
							<div class="collapse show">
								<div class="collapse-body">
									<div class="grid light m-b row row-cols-md-3 row-cols-sm-2 row-cols-1">
										
										
											
										@while(have_posts()) @php the_post() @endphp
											@php
												$tourism_locations = wp_get_post_terms( get_the_id(), 'tourism-location', array( 'fields' => 'names' ) );
												$location = '';
												foreach ( $tourism_locations as $key => $tourism_location ) {
													if ( $key > 0 ) {
														$location .= ', '.$tourism_location;
													} else {
														$location .= $tourism_location;
													}
												}
											@endphp
											<div class="col grid-item">
												<figure>
													<div class="thumbnail">
														<div class="aspectratio-4-3">
															<div class="img" style="background-image: url({!! get_the_post_thumbnail_url( get_the_id(), 'thumbnail' ) !!});"></div>
														</div>
													</div>
													<figcaption class="block text-left">
														<i class="icofont-location-pin"></i>
														<small>{{ $location }}</small>
														<h6 class="m-0">
															<a href="{{ get_permalink() }}">{!! get_the_title() !!}</a>
														</h6>
													</figcaption>
												</figure>
											</div>
										@endwhile

									</div>
									@include('partials.paginate-link')
									@if ( !have_posts() )
										<div class="alert alert-warning">
											{{ __('Sorry, no results were found.', 'egov') }}
										</div>
									@endif
								</div>
							</div>
						</div>
					@else
						<div class="tab-pane fade" role="tabpanel">
							<div class="collapse-title">
								<button class="btn btn-link btn-block collapsed" type="button">
									<a href="{{ get_term_link( $term->term_id ) }}">{{ $term->name }} ({{ $term->count }})</a>
								</button>
							</div>
						</div>
					@endif
				@endforeach

			</div>
		</div>
	</div>
@endsection
