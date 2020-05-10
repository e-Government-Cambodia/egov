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
                <input type="search" name="s" class="text-field form-control" placeholder="{{ __('Search All Government', 'egov' ) }}" value="{!! the_search_query() !!}">
                <div class="input-group-append">
                    <button type="submit" class="submit-field btn btn-primary"><span class="d-none d-md-inline">Search</span> <i class="icofont-search"></i></button>
                </div>
            </div>
        </form>
        <ul>
            <li>
                <label>Popular Keywords:</label>
                <ul>
                    <li><a href="#">driver's license</a></li>
                    <li><a href="#">free health service</a></li>
                    <li><a href="#">birth registration</a></li>
                </ul>
            </li>
        </ul>
    </div>
</section>