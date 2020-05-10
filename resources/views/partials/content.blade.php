

<div class="col">
  <article class="wrap-item row">
  <div class="col-2">
      <div class="thumbnail">
          <figure class="aspectratio-1-1     ">
              <div class="img" style="background-image: url({!! get_the_post_thumbnail_url( get_the_id(), 'thumbnail' ) !!});"></div>
          </figure>
      </div>
  </div>
      <div class="col">
          <h5 class="title"><a href="{{ get_permalink() }}">{!! get_the_title() !!}</a></h5>
          <div class="excerpt">
            @php the_excerpt() @endphp  
          </div>
          <div class="meta d-block">
              @include('partials/entry-meta')
          </div>
      </div>
  </article>
</div>
