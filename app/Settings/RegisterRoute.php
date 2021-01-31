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
        register_rest_route( 'wp/v2', '/get-term-for/(?P<param>[a-zA-Z0-9-]+)', array(
            // By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
            'methods'  => \WP_REST_Server::READABLE,
            'callback' => array( $this, 'getTermList' )
        ) );
        register_rest_route( 'wp/v2', '/get-union-term/topic=(?P<topic>[a-zA-Z0-9-]+)/for=(?P<for>[a-zA-Z0-9-]+)/base=(?P<base>[a-zA-Z0-9-.]+)/page=(?P<page>[a-zA-Z0-9-_]+)', array(
            // By using this constant we ensure that when the WP_REST_Server changes our readable endpoints will work as intended.
            'methods'  => 'GET',
            'callback' => array( $this, 'getUnionTermList' )
        ) );
    }    

    public function getTermList( $request ) {
        
     
        $param = $request['param'];
        
        $union_terms = array();

        if ( $param ) {
            
            $terms = get_terms( array( 
                'taxonomy' => 'service-topic', 
                'hide_empty' => true, 
                'parent' => 0 
            ) );

            $union_terms = array_values( $terms );
            
            if ( $param ) {
                
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
                                'terms'    => $param
                            ),
                            array(
                                'taxonomy' => 'service-topic',
                                'field'    => 'term_id',
                                'terms'    => $term->term_id
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
        $base = $request['base'];
        $page = $request['page'];
        $taxonomy = 'service-topic';
        $ssl = 'https';
        $html = '';
        
        $child_object = get_terms( array(
            'taxonomy' => $taxonomy,
            'hide_empty' => true,
            'parent' => $topic
        ) ) ;

        $current_term = get_term( $topic, $taxonomy );
        // return rest_ensure_response( $current_term );

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
								foreach ( $child_object as $key => $obj ) {
                                    $boolean = ($key === 0) ? 'true' : 'false';
                                    $active = ($key === 0) ? 'active' : '';
                                    $html .= '
                                        <a id="tab-collapse-'.$obj->term_id.'" data-toggle="pill" href="#tab-'.$obj->term_id.'" aria-controls="tab-'.$obj->term_id.'" aria-selected="'.$boolean.'" class="nav-link w-100 '.$active.'">
                                            <strong>'.$obj->name.'</strong>
                                        </a>
                                    ';
                                }	
            $html .= '							
							</div>
                        </div>
                        <div class="col-12 col-md">
                            <div class="tab-content" id="accordion-tab-collapse">
            ';
								foreach ( $child_object as $key => $obj ) {
                                    $boolean = ($key === 0) ? 'true' : 'false';
                                    $active = ($key === 0) ? 'active show' : '';
                                    $collapsed = ($key === 0) ? '' : 'collapsed';
                                    $show = ($key === 0) ? 'show' : '';
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
														
                                                        $subterm = get_terms( array(
                                                            'taxonomy' => $obj->taxonomy,
                                                            'hide_empty' => true,
                                                            'parent' => $obj->term_id
                                                        ) ) ;
														
														if ( count( $subterm ) ) {
                                                            $html .= '
                                                            <div class="col">
                                                                <article class="wrap-item">
                                                            ';
																	foreach ( $subterm as $term ) {
																		$html .= '<a class="text-light p-1 bg-primary" href="'.get_term_link( $topic ).'#tab-'.$term->term_id.'">'.$term->name.'</a>';
                                                                    }
                                                            $html .= '
																</article>
                                                            </div>
                                                            ';
                                                        }
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
                                                                    'taxonomy' => $taxonomy,
                                                                    'field'    => 'slug',
                                                                    'terms'    => $obj->slug,
                                                                )
                                                            ),
                                                            'posts_per_page' => -1
                                                        );
                                                        $query = new \WP_Query( $args );
														if ( $query->have_posts() ) {
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
                                                        }
                                                        wp_reset_postdata();
                                    $html .= '
													</div>
												</section>
											</div>
										</div>
                                    </div>
                                    ';
                                }	
                                
			$html .= '		</div>
						</div>
                    </div>
                </div>
            </section>
            ';
        }

        return rest_ensure_response( $html );
    }
}