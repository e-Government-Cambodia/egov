<section>
    @php
    if ( function_exists('yoast_breadcrumb') ) {
      yoast_breadcrumb( '<nav aria-label="breadcrumb" class="breadcrumb light">','</nav>' );
    }
    @endphp
</section>