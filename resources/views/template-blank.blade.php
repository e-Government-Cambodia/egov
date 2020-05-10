{{--
  Template Name: Blank
  Template Post Type: page, post, tourism, service
--}}

@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp
    @include('partials.content-blank')
  @endwhile
@endsection
