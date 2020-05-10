@if ( paginate_links() ) 
  <div class="mb-md-6 mb-sm-4 mb-3 text-center">
    <nav class="navigation pagination light" role="navigation" aria-label="Posts">
        <div class="nav-links">
            {!! paginate_links() !!}
        </div>
    </nav>
  </div>
@endif