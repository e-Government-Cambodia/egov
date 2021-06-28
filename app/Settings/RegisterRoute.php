<?php
/**
 * @package EgovBlock
 */

namespace App\Settings;

class RegisterRoute
{
  
    public function register() {
        add_action( 'rest_api_init', array( $this, 'registerCallback') );
    }

    public function registerCallback() {
        register_rest_route( 'wp/v2', 
            '/get-all-posts/type=(?P<type>[a-zA-Z0-9-]+)/level=(?P<level>[a-zA-Z0-9-,]+)/lang=(?P<lang>[a-zA-Z0-9-]+)/base=(?P<base>[a-zA-Z0-9-.]+)/page=(?P<page>[a-zA-Z0-9-_]+)', 
            array(
                // By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
                'methods'  => \WP_REST_Server::READABLE,
                'callback' => array( $this, 'getAllPosts' ),
                'permission_callback' => '__return_true'
            )
        );
        register_rest_route( 'wp/v2', '/get-term-for/for=(?P<for>[a-zA-Z0-9-]+)/level=(?P<level>[a-zA-Z0-9-,]+)', array(
            // By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
            'methods'  => \WP_REST_Server::READABLE,
            'callback' => array( $this, 'getTermList' ),
            'permission_callback' => '__return_true'
        ) );
        register_rest_route( 'wp/v2', '/get-union-term/topic=(?P<topic>[a-zA-Z0-9-]+)/for=(?P<for>[a-zA-Z0-9-]+)/level=(?P<level>[a-zA-Z0-9-,]+)/base=(?P<base>[a-zA-Z0-9-.]+)/page=(?P<page>[a-zA-Z0-9-_]+)', array(
            // By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
            'methods'  => 'GET',
            'callback' => array( $this, 'getUnionTermList' ),
            'permission_callback' => '__return_true'
        ) );
    }   
    
    public function getAllPosts( $request ) {
        $type = $request['type'];
        $level = explode(",", $request['level']);
        $lang = $request['lang'];
        $base = $request['base'];
        $page = $request['page'];
        $ssl = 'https';

        // Initialize the array that will receive the posts' data. 
        $data = array();

        // Get the posts using the 'post' and 'news' post types 
        $posts = get_posts( array(
                'post_type' => $type,
                'lang' => $lang,
                'posts_per_page' => -1,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'service-level',
                        'field'    => 'term_id',
                        'terms'    => $level
                    )
                )
            )
        );

        // Loop through the posts and push the desired data to the array we've initialized earlier in the form of an object
        foreach( $posts as $post ) {
            // array_push( $data, array(
            //     "title" => $post->post_title,
            //     "url" => $ssl.'://'.$base.'/'.$page.'?service_id='.$post->ID
            // ) );
            
            // $data[] = $post->post_title.'<p hidden>-----'.$ssl.'://'.$base.'/'.$page.'?service_id='.$post->ID.'-----</p>';
            $data[] = [
                "title" => $post->post_title,
                "url" => $ssl.'://'.$base.'/'.$page.'?service_id='.$post->ID
            ];  
        }                  
        return rest_ensure_response( $data ); 
    }

    public function getTermList( $request ) {
        
     
        $service_for = $request['for'];
        $service_level = explode(",", $request['level']);
        
        $union_terms = array();

        if ( $service_for && $service_level ) {
            
            $terms = get_terms( array( 
                'taxonomy' => 'service-topic', 
                'hide_empty' => true, 
                'parent' => 0 
            ) );

            $union_terms = array_values( $terms );
            
            if ( $service_for ) {
                
                $union_terms = array();
                foreach ( $terms as $term ) {
                    // Attribute for WP_Query class
                    $args = array(
                        'post_type' => 'service',
                        'tax_query' => array(
                            'relation' => 'AND',
                            array(
                                'taxonomy' => 'service-for',
                                'field'    => 'term_id',
                                'terms'    => $service_for
                            ),
                            array(
                                'taxonomy' => 'service-topic',
                                'field'    => 'term_id',
                                'terms'    => $term->term_id
                            ),
                            array(
                                'taxonomy' => 'service-level',
                                'field'    => 'term_id',
                                'terms'    => $service_level
                            )
                        ),
                        'posts_per_page' => 1
                    );
                        
                    $the_query = new \WP_Query( $args );
                    if ( $the_query->have_posts() ) {
                        array_push( $union_terms, $term );
                    }
                    // Restore original Post Data
                    wp_reset_postdata();
                }
            }
        }

        $html = '';
        $html =
            '
            <div class="">
                <div class="block-topic">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
            '
        ;

        // Enable customize term meta key for third party integration
        $meta_key = 'egov_service_topic_icon';
        $data = array();
        foreach ( $union_terms as $key => $term ) {
            array_push (
                $data,
                array(
                    'id' => $term->term_id,
                    'slug' => $term->slug,
                    'name' => $term->name,
                    'description' => $term->description,
                    'icon' => get_term_meta( $term->term_id, $meta_key, true )
                )
            );
        }
                                 
        return rest_ensure_response( $data );                   
    } 

    public function getUnionTermList( $request ) {
        $topic = $request['topic'];
        $for = $request['for'];
        $level = explode(",", $request['level']);
        $base = $request['base'];
        $page = $request['page'];
        $taxonomy_topic = 'service-topic';
        $ssl = 'https';
        $html = '';
        
        $child_object = get_terms( array(
            'taxonomy' => $taxonomy_topic,
            'hide_empty' => true,
            'parent' => $topic
        ) ) ;

        $current_term = get_term( $topic, $taxonomy_topic );
        // return rest_ensure_response( $current_term );
        $html.='
        <section>
            <header class="block-heading text-left">
                <h4 class="text-danger font-weight-bold">
                    '.$current_term->name.'
                </h4>
            </header>
        </section>
        ';
        $thumbnail = get_term_meta( $topic, 'egov_service_topic_thumbnail', true );
        if ( $thumbnail )
        $html .= '<section class="wp-block-egov-block-hero-banner"><figure class="hero-banner"><div class="aspectratio-4-1"><div class="img blend" style="background-image:url( '.$thumbnail.' );background-color:rgba(0, 0, 0, 0.55)"></div></div><figcaption class="hero-content d-flex"><div class="my-auto"><h2 class="hero-title">'.$current_term->description.'</h2></div></figcaption></figure></section>';
        
        
        
        if( count( $child_object ) ) {
            $html .= '
            <section class="service-detail">
				<div class="tab-collapse">
					<div class="row row-cols-2">
						<div class="col-12 col-md-4">
                            <div id="tab-collapse" role="tablist" aria-orientation="vertical" class="nav m-0">
            ';
                                $zin = true;
								foreach ( $child_object as $key => $obj ) {
                                    $boolean = ($zin) ? 'true' : 'false';
                                    $active = ($zin) ? 'active' : '';

                                    $args = array(
                                        'post_type' => 'service',
                                        'tax_query' => array(
                                            'relation' => 'AND',
                                            array(
                                                'taxonomy' => 'service-for',
                                                'field'    => 'term_id',
                                                'terms'    => $for
                                            ),
                                            array(
                                                'taxonomy' => $taxonomy_topic,
                                                'field'    => 'slug',
                                                'terms'    => $obj->slug,
                                            ),
                                            array(
                                                'taxonomy' => 'service-level',
                                                'field'    => 'term_id',
                                                'terms'    => $level,
                                            )
                                        ),
                                        'posts_per_page' => -1
                                    );
                                    $query = new \WP_Query( $args );
                                    if ( $query->have_posts() ) {
                                    $html .= '
                                        <a id="tab-collapse-'.$obj->term_id.'" data-toggle="pill" href="#tab-'.$obj->term_id.'" aria-controls="tab-'.$obj->term_id.'" aria-selected="'.$boolean.'" class="nav-link w-100 '.$active.'">
                                            <strong>'.$obj->name.'</strong>
                                        </a>
                                    ';
                                    $zin = false;
                                    }
                                    wp_reset_postdata();
                                }	
            $html .= '							
							</div>
                        </div>
                        <div class="col-12 col-md">
                            <div class="tab-content" id="accordion-tab-collapse">
            ';
                                $zin = true;
								foreach ( $child_object as $key => $obj ) {
                                    $boolean = ($zin) ? 'true' : 'false';
                                    $active = ($zin) ? 'active show' : '';
                                    $collapsed = ($zin) ? '' : 'collapsed';
                                    $show = ($zin) ? 'show' : '';
                                    $args = array(
                                        'post_type' => 'service',
                                        'tax_query' => array(
                                            'relation' => 'AND',
                                            array(
                                                'taxonomy' => 'service-for',
                                                'field'    => 'term_id',
                                                'terms'    => $for
                                            ),
                                            array(
                                                'taxonomy' => $taxonomy_topic,
                                                'field'    => 'slug',
                                                'terms'    => $obj->slug,
                                            ),
                                            array(
                                                'taxonomy' => 'service-level',
                                                'field'    => 'term_id',
                                                'terms'    => $level,
                                            )
                                        ),
                                        'posts_per_page' => -1
                                    );
                                    $query = new \WP_Query( $args );
                                    if ( $query->have_posts() ) {
                                    $html .= '
									<div id="tab-'.$obj->term_id.'" role="tabpanel" aria-labelledby="tab-collapse-'.$obj->term_id.'" class="tab-pane fade '.$active.'">
										<div id="heading-'.$obj->term_id.'" class="collapse-title">
											<button data-toggle="collapse" data-tab="#tab-'.$obj->term_id.'" data-target="#collapse-tab-'.$obj->term_id.'" aria-expanded="'.$boolean.'" aria-controls="collapse-tab-'.$obj->term_id.'" class="btn btn-link btn-block '.$collapsed.'" type="button">
												<strong>'.$obj->name.'</strong>
											</button>
										</div>
										<div id="collapse-tab-'.$obj->term_id.'" aria-labelledby="heading-'.$obj->term_id.'" data-parent="#accordion-tab-collapse" class="collapse '.$show.'">
											<div class="collapse-body">
												<section>
                                                    <div class="block-list">
                                    ';
														
															while ( $query->have_posts() ) {
                                                                $query->the_post();
                                                                $html .= '
																<div class="col">
                                                                    <article class="wrap-item hrb">
                                                                        <h5 class="title"><a href="'.$ssl.'://'.$base.'/'.$page.'?service_id='.get_the_id().'">'.get_the_title().'</a></h5>
                                                                        <div class="excerpt">
                                                                            '.get_the_excerpt().'
                                                                        </div>
                                                                    </article>
                                                                </div>
                                                                ';
                                                            }
                                    $html .= '
													</div>
												</section>
											</div>
										</div>
                                    </div>
                                    ';
                                    $zin = false;
                                    }
                                    wp_reset_postdata();
                                }	
                                
			$html .= '		</div>
						</div>
                    </div>
                </div>
            </section>
            ';
        } else { //$html.= 'for='.$for.'&topic='.$topic.'&level='.$level;
            $args = array(
                'post_type' => 'service',
                'tax_query' => array(
                    'relation' => 'AND',
                    array(
                        'taxonomy' => 'service-for',
                        'field'    => 'term_id',
                        'terms'    => $for
                    ),
                    array(
                        'taxonomy' => $taxonomy_topic,
                        'field'    => 'term_id',
                        'terms'    => $topic,
                    ),
                    array(
                        'taxonomy' => 'service-level',
                        'field'    => 'term_id',
                        'terms'    => $level,
                    )
                ),
                'posts_per_page' => -1
            );
            $query = new \WP_Query( $args );
            if ( $query->have_posts() ) {
                $html .= '
                <section>
                    <div class="block-list">
                ';
                while ( $query->have_posts() ) {
                    $query->the_post();
                    $html .= '
                    <div class="col">
                        <article class="wrap-item hrb">
                            <h5 class="title"><a href="'.$ssl.'://'.$base.'/'.$page.'?service_id='.get_the_id().'">'.get_the_title().'</a></h5>
                            <div class="excerpt">
                                '.get_the_excerpt().'
                            </div>
                        </article>
                    </div>
                    ';
                }
                $html .= '
                    </div>
                </section>
                ';
            }
            wp_reset_postdata();
        }
        
        return rest_ensure_response( $html );
    }
}