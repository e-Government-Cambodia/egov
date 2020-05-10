@extends('layouts.app')

@section('content')
  <div class="container">
    @include('partials.search')
    @include('partials.page-header')
  
    @if (!have_posts())
      <div class="alert alert-warning">
        {{ __('Sorry, but the page you were trying to view does not exist.', 'egov') }}
      </div>
    @endif
  </div>
@endsection
