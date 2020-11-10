@extends('layouts.app')

@section('content')
  	<div class="container">
		@while(have_posts()) @php the_post() @endphp
			@include('partials.search')
			@include('partials.page-header')
			{{-- @include('partials.breadcrumbs') --}}
			@include('partials.content-single-'.get_post_type())
			@include('partials.related-'.get_post_type())
			@php comments_template('/partials/comments.blade.php') @endphp
		@endwhile
  	</div>
@endsection
