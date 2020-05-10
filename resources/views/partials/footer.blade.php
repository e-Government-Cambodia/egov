<footer>
  <div class="container-fluid">
      <nav class="d-md-flex justify-content-between"> 
          @if ( has_nav_menu( 'social_menu' ) )
          <ul class="d-flex justify-content-center social">
            <li>{{ __( 'Follow Us', 'egov' ) }}</li>
            {!! 
                wp_nav_menu( 
                array(
                    'theme_location' => 'social_menu',
                    'container' => false,
                    'items_wrap' => '%3$s'
                )
                ) 
            !!}
          </ul>
        @endif

        @if ( has_nav_menu( 'footer_menu' ) )
            {!! 
                wp_nav_menu( 
                array(
                    'theme_location' => 'footer_menu',
                    'container' => false,
                    'menu_class' => 'd-flex justify-content-center footer-nabar'
                )
                ) 
            !!}
        @endif
      </nav>
  </div>
    @if ( is_active_sidebar( 'sidebar-footer' ) )
        <div class="container-fluid text-center">
            <small class="copyright">
                @php dynamic_sidebar( 'sidebar-footer' ) @endphp
            </small>
        </div>
    @endif
</footer>
<div class="scroll-to-top">
  <a href="#body"><i class="icofont-arrow-up"></i></i></a>
</div>
