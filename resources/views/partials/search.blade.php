<section>
    <div class="form-search without-slideshow">
        <form 
            @if ( function_exists( 'pll_home_url' ) )
                action="{{ pll_home_url() }}"
            @else
                action="{{ home_url() }}"
            @endif
            method="get">
            <div class="input-field input-group">
                <div class="text-field form-control p-0">
                    <input @php if ( function_exists( 'pll_current_language' ) ) echo 'data-lang='.pll_current_language() @endphp type="search" autocomplete="off" name="s" class="text-field form-control typeahead" placeholder="<?php echo __( 'Search All Government', 'egov' ) ?>" value="{!! the_search_query() !!}">
                </div>
                <div class="input-group-append">
                    <button type="submit" class="submit-field btn btn-primary"><span class="d-none d-md-inline">{{ __( 'Search', 'egov' ) }}</span> <i class="icofont-search"></i></button>
                </div>
            </div>
        </form>
        {{-- <ul>
            <li>
                <label>{{ __( 'Popular Keywords', 'egov' ) }}:</label>
                <ul>
                    <li><a href="#">driver's license</a></li>
                    <li><a href="#">free health service</a></li>
                    <li><a href="#">birth registration</a></li>
                </ul>
            </li>
        </ul> --}}
    </div>
</section>
