@extends('layouts.app')

@section('content')
	<div class="container">
		@include('partials.search')
		@include('partials.page-header')
		@if (!have_posts())
			<div class="alert alert-warning">
				{{ __('Sorry, no results were found.', 'egov') }}
			</div>
		@endif
		<section class="block-list match-search" data-id="block-list-01" data-match="{!! the_search_query() !!}">
			@while(have_posts()) @php the_post() @endphp
				@include('partials.content-search')
			@endwhile
		</section>

		@include('partials.paginate-link')
	</div>
@endsection
