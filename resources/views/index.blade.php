@extends('layouts.app')

@section('content')
  <div class="container">
    @include('partials.search')
    @include('partials.page-header')
    @include('partials.breadcrumbs')
    @if (!have_posts())
      <div class="alert alert-warning">
        {{ __('Sorry, no results were found.', 'egov') }}
      </div>
    @endif
    <div class="block-list">
      <div class="row row-cols-1">
        @while(have_posts()) @php the_post() @endphp
          @include('partials.content-'.get_post_type())
        @endwhile
      </div>
    </div>

    @include('partials.paginate-link')
  </div>
@endsection
