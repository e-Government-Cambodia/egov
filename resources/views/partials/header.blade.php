<header class="container d-lg-flex justify-content-between header">
  <figure class="d-flex m-0">
      <a class="mr-3" 
        @if ( function_exists( 'pll_home_url' ) )
          href="{{ pll_home_url() }}"
        @else
          href="{{ home_url() }}"
        @endif
      >
        <picture>
            @if ( get_theme_mod( 'logo_large_setting_id' ) )                
              <source media="(min-width: 992px)" srcset="{{ wp_get_attachment_url( get_theme_mod( 'logo_large_setting_id' ) ) }}" type="image/jpeg">
            @else
              <source media="(min-width: 992px)" srcset="{{ get_stylesheet_directory_uri() }}/assets/images/cambodia-logo@3x.png" type="image/jpeg">
            @endif
            
            @if ( get_theme_mod( 'logo_medium_setting_id' ) )                
              <source media="(min-width: 768px)" srcset="{{ wp_get_attachment_url( get_theme_mod( 'logo_medium_setting_id' ) ) }}" type="image/jpeg">
            @else
              <source media="(min-width: 768px)" srcset="{{ get_stylesheet_directory_uri() }}/assets/images/cambodia-logo@2x.png" type="image/jpeg">
            @endif
            
            @if ( get_theme_mod( 'logo_small_setting_id' ) )                
              <source media="(max-width: 767px)" srcset="{{ wp_get_attachment_url( get_theme_mod( 'logo_small_setting_id' ) ) }} 1x, {{ wp_get_attachment_url( get_theme_mod( 'logo_medium_setting_id' ) ) }} 2x" type="image/jpeg">
              <img src="{{ wp_get_attachment_url( get_theme_mod( 'logo_small_setting_id' ) ) }}" type="image/jpeg">
            @else
              <source media="(max-width: 767px)" srcset="{{ get_stylesheet_directory_uri() }}/assets/images/cambodia-logo@1x.png 1x, {{ get_stylesheet_directory_uri() }}/assets/images/cambodia-logo@2x.png 2x" type="image/jpeg">
              <img src="{{ get_stylesheet_directory_uri() }}/assets/images/cambodia-logo@1x.png" type="image/jpeg">
            @endif
        </picture>

      </a>
      <figcaption class="title">
        <h2 class="site-title">{{ get_bloginfo('name' ) }}</h2>
        <p class="tagline">{{ get_bloginfo( 'description' ) }}</p>
      </figcaption>
  </figure>
  
  
  @if( function_exists( 'pll_the_languages' ) )
    <ul class="my-auto text-center list-inline d-none d-lg-block language">
    @php
      $args = array(
        'hide_if_empty' => 0,
        'raw' => 1
      );
    @endphp
    @foreach ( pll_the_languages( $args ) as $key => $value )
    
      <li class="list-inline-item">
        <a 
          @if ( pll_current_language() === $value['slug'] )
              class="font-weight-bold current"
          @endif
          href="{{ $value['url'] }}
        ">
          <img 
            @switch( $value['slug'] )
              @case( 'km' )
                srcset="{{ get_stylesheet_directory_uri() }}/assets/images/kh@2x.jpg 2x" 
                src="{{ get_stylesheet_directory_uri() }}/assets/images/kh.jpg" 
                @break
              @case( 'en' )
                srcset="{{ get_stylesheet_directory_uri() }}/assets/images/en@2x.jpg 2x" 
                src="{{ get_stylesheet_directory_uri() }}/assets/images/en.jpg" 
                @break
              @default
            @endswitch      
          />
          <span>{{ $value['name'] }}</span>
        </a>
      </li>
    
    @endforeach
    </ul>
  @endif
</header>
<style type="text/css">
/*Extra small devices (portrait phones, less than 576px)*/
@media (max-width: 767.98px) {
  .header { padding-top: 5px; padding-bottom: 5px; }
  .header .title { text-align: center; margin-top: 6px; }
  .header .title .site-title { font-size: 18px; margin-bottom: 5px; }
  .header .title .tagline { font-size: 12px; margin-bottom: 5px; }
}

/*Medium devices (tablets, 768px and up)*/
@media (min-width: 768px) and (max-width: 991.98px) {
  .header { padding-top: 10px; padding-bottom: 10px; }
  .header .title { text-align: center; margin-top: 10px; }
  .header .title .site-title { font-size: 28px; margin-bottom: 5px; }
  .header .title .tagline { font-size: 18px; margin-bottom: 5px; }
}

/*Large devices (desktops, 992px and up)*/
@media (min-width: 992px) {
  .header { padding-top: 15px; padding-bottom: 15px; }
  .header .title { text-align: center; margin-top: 20px; }
  .header .title .site-title { font-size: 32px; margin-bottom: 5px; }
  .header .title .tagline { font-size: 20px; margin-bottom: 5px; }
}

</style>

@if ( has_nav_menu( 'main_menu' ) )
<nav class="navbar navbar-expand-lg navbar-light p-0">
  <div class="container">
    @if( function_exists( 'pll_the_languages' ) )
      <ul class="text-center list-inline navbar-brand my-auto ml-3 d-lg-none language">
      @php
        $args = array(
          'hide_if_empty' => 0,
          'raw' => 1
        );
      @endphp
      @foreach ( pll_the_languages( $args ) as $key => $value )
      
        <li class="list-inline-item">
          <a 
            @if ( pll_current_language() === $value['slug'] )
                class="font-weight-bold current"
            @endif
            href="{{ $value['url'] }}
          ">
            <img 
              @switch( $value['slug'] )
                @case( 'km' )
                  srcset="{{ get_stylesheet_directory_uri() }}/assets/images/kh@2x.jpg 2x" 
                  src="{{ get_stylesheet_directory_uri() }}/assets/images/kh.jpg" 
                  @break
                @case( 'en' )
                  srcset="{{ get_stylesheet_directory_uri() }}/assets/images/en@2x.jpg 2x" 
                  src="{{ get_stylesheet_directory_uri() }}/assets/images/en.jpg" 
                  @break
                @default
              @endswitch      
            />
            <span>{{ $value['name'] }}</span>
          </a>
        </li>
      
      @endforeach
      </ul>
    @endif
    <button class="mr-3 my-2 navbar-toggler navbar-toggler-right text-white nav-icon collapsed" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <div></div>
    </button>
    <div class="collapse navbar-collapse" id="main-menu">
      
      {!! 
        wp_nav_menu( 
          array(
            'theme_location' => 'main_menu',
            'container' => false
          )
        ) 
      !!}
      
    </div>
  </div>
</nav>
@endif

<style type="text/css">
/* custom theme options default for navbar */
.navbar { background-color: #f8f9fa; }
.navbar .navbar-toggler { background-color: #254187; }
/*desktop screen*/
@media (min-width: 992px) {
  /*level 1*/
  .navbar ul.menu > li > a { margin-right:30px; color: #343a40; font-size: 18px; padding-top: 15px; padding-bottom: 15px; padding-left: 20px; padding-right: 20px; }
  /*level 1 on hover*/
  .navbar ul.menu > li > a:hover { color: #343a40; background-color: rgba(0, 0, 0, 0.1); }
  /*level 1 on active*/
  .navbar ul.menu > li.current-menu-item > a,
  .navbar ul.menu > li.current-post-ancestor > a,
  .navbar ul.menu > li.current-post-ancestor > a,
  .navbar ul.menu > li.current-page-ancestor > a { background-color: #254187; color: #fff; }
  /*level 1 dropdown arrow color*/
  .navbar ul.menu > li.menu-item-has-children > a::after { border-top-color: rgba(0, 0, 0, 0.1); }
  /*level 1 dropdown arrow color on active*/
  .navbar ul.menu > li.menu-item-has-children.current-menu-item > a::after,
  .navbar ul.menu > li.menu-item-has-children.current-menu-ancestor > a::after,
  .navbar ul.menu > li.menu-item-has-children.current-page-ancestor > a::after,
  .navbar ul.menu > li.menu-item-has-children.current-post-ancestor > a::after { border-top-color: #fff; }
  
  /*nex level*/
  .navbar ul.menu li ul { background-color: #F5F6FA; min-width: 220px; }
  .navbar ul.menu li ul li a { color: #343a40; font-size: 17px; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px; }
  /*next level on active */
  .navbar ul.menu li ul li.current-menu-item > a,
  .navbar ul.menu li ul li.current-menu-ancestor > a,
  .navbar ul.menu li ul li.current-page-ancestor > a,
  .navbar ul.menu li ul li.current-post-ancestor > a,
  .navbar ul.menu li ul li a:hover { color: #343a40; background-color: rgba(0, 0, 0, 0.1); }
  /*next level dropdown arrow color*/
  .navbar ul.menu li ul li.menu-item-has-children > a::after { border-left-color: rgba(0, 0, 0, 0.1); }
  /*next level dropdown arrow color on active*/
  .navbar ul.menu li ul li.menu-item-has-children.current-menu-item > a::after,
  .navbar ul.menu li ul li.menu-item-has-children.current-menu-ancestor > a::after,
  .navbar ul.menu li ul li.menu-item-has-children.current-page-ancestor > a::after,
  .navbar ul.menu li ul li.menu-item-has-children.current-post-ancestor > a::after { border-left-color: rgba(0, 0, 0, 0.1); }
}
/* medium devices (tablets, 768px and up) */
@media (min-width: 0px) and (max-width: 991.98px) {
  /*level 1*/
  .navbar ul.menu > li > a { color: #343a40; font-size: 16px; padding-top: 10px; padding-bottom: 10px; padding-left: 15px; padding-right: 15px; }
  /*level 1 on active*/
  .navbar ul.menu li.current-menu-item > a,
  .navbar ul.menu li.current-post-ancestor > a,
  .navbar ul.menu li.current-page-ancestor > a,
  .navbar ul.menu li.current-menu-ancestor > a { background-color: transparent; color: #343a40; font-weight: bold;}
  /*level 1 dropdown arrow color*/
  .navbar ul.menu > li.menu-item-has-children > a::after { border-top-color: rgba(0, 0, 0, 0.1); }
  /*level 1 dropdown arrow color on active*/
  .navbar ul.menu > li.menu-item-has-children.current-menu-item > a::after,
  .navbar ul.menu > li.menu-item-has-children.current-menu-ancestor > a::after,
  .navbar ul.menu > li.menu-item-has-children.current-page-ancestor > a::after,
  .navbar ul.menu > li.menu-item-has-children.current-post-ancestor > a::after { border-top-color: rgba(0, 0, 0, 0.1); }

  /*nex level*/
  .navbar ul.menu li ul { background-color: #F5F6FA; min-width: 220px; }
  .navbar ul.menu li ul li a { color: #343a40; font-size: 15px; padding-top: 10px; padding-bottom: 10px; padding-left: 20px; padding-right: 20px; }
  /*next level on active */
  .navbar ul.menu li ul li.current-menu-item > a,
  .navbar ul.menu li ul li.current-page-ancestor > a,
  .navbar ul.menu li ul li.current-menu-ancestor > a,
  .navbar ul.menu li ul li.current-post-ancestor > a,
  .navbar ul.menu li ul li a:hover { color: #343a40; background-color: transparent; font-weight: bold; }
  /*next level dropdown arrow color*/
  .navbar ul.menu li ul li.menu-item-has-children > a::after { border-top-color: rgba(0, 0, 0, 0.1); }
  /*next level dropdown arrow color on active*/
  .navbar ul.menu li ul li.menu-item-has-children.current-menu-item > a::after,
  .navbar ul.menu li ul li.menu-item-has-children.current-menu-ancestor > a::after,
  .navbar ul.menu li ul li.menu-item-has-children.current-page-ancestor > a::after,
  .navbar ul.menu li ul li.menu-item-has-children.current-post-ancestor > a::after { border-top-color: rgba(0, 0, 0, 0.1); }
}
</style>