<div class="col">
    <article class="wrap-item hrb">
        <h5 class="title"><a href="{{ get_permalink() }}">{!! get_the_title() !!}</a></h5>
        <div class="excerpt">
            @php the_excerpt() @endphp  
        </div>
    </article>
</div>
