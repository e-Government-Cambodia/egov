
<article class="wrap-item hrb">
    <h5 class="title"><a target="_blank" href="{{ get_permalink() }}">{!! get_the_title() !!} <i class="ml-4 icofont-external-link"></i></a></h5>
    <div class="excerpt">
        @php the_excerpt() @endphp  
    </div>
    <div class="meta d-block">
        @include('partials/entry-meta')
    </div>
</article>
