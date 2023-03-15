<?php
/*
Addon: TEAMVISION Functions 
*/

/** Get Animations **/
if(!function_exists('bloglayouts_animate_class')) {
	function bloglayouts_animate_class($addon_animate,$effect,$delay) {
		if($addon_animate == 'on') : 
			wp_enqueue_script( 'appear' );			
			wp_enqueue_script( 'animate' );		
			$animate_class = ' animate-in" data-anim-type="'.$effect.'" data-anim-delay="'.$delay.'"'; 
		else :
			$animate_class = '"';
		endif;		
		return $animate_class;
	}
}

/** Get Category **/
if(!function_exists('bloglayouts_get_category')) {
	function bloglayouts_get_category($source,$posts_type,$css_link,$limit = 1) {
		$separator = ' ';
		$output = '';	
		$count = 1;
		if($source=='wp_posts') {			
			$categories = get_the_category();
			if($categories){
				foreach($categories as $category) {
					$output .= '<a href="'.get_category_link( $category->term_id ).'" title="' . esc_attr( sprintf( __( "View all posts in %s",'elementor-blog-layouts' ), $category->name ) ) . '" '.$css_link.'>'.esc_html($category->cat_name).'</a>'.esc_html($separator);
					if($count == $limit) { break; }
					$count++;
				}
			}
		} elseif($source=='post_type') {
			global $post;
			$taxonomy_names = get_object_taxonomies( $posts_type );
			$term_list = wp_get_post_terms($post->ID,$taxonomy_names);
			if($term_list){
				foreach ($term_list as $tax_term) {
					$output .= '<a href="' . esc_attr(get_term_link($tax_term, $posts_type)) . '" title="' . sprintf( __( "View all posts in %s",'elementor-blog-layouts' ), $tax_term->name ) . '" '.$css_link.'>' . esc_html($tax_term->name) .'</a>'.esc_html($separator);
				}
			}
		}
		$return = trim($output, $separator);
		return $return;
	}
}

/** Get Author **/
if(!function_exists('bloglayouts_get_author')) {
	function bloglayouts_get_author($css_link) {
		$return = '<a href="'.get_author_posts_url( get_the_author_meta( 'ID' ) ).'" '.$css_link.'>'.get_the_author_meta( 'display_name' ).'</a>';
		return $return;
	}	
}

/** Get Comments **/
if(!function_exists('bloglayouts_get_num_comments')) {	
	function bloglayouts_get_num_comments($css_comment,$css_comment_link) {
			$num_comments = get_comments_number();

			if ( $num_comments == 0 ) {
					$comments = esc_html__('No Comments','elementor-blog-layouts');
					$return = $comments;
			} elseif ( $num_comments > 1 ) {
					$comments = $num_comments . esc_html__(' Comments','elementor-blog-layouts');
					$return = '<a href="' . get_comments_link() .'" '.$css_comment_link.'>'. esc_html($comments).'</a>';
			} else {
					$comments = esc_html__('1 Comment','elementor-blog-layouts');
					$return = '<a href="' . get_comments_link() .'" '.$css_comment_link.'>'. esc_html($comments) .'</a>';
			}
			return $return;
	}
}

if(!function_exists('bloglayouts_get_only_num_comments')) {
	function bloglayouts_get_only_num_comments($css_comment,$css_comment_link) {
			$num_comments = get_comments_number();

			if ( $num_comments == 0 ) {
					$return = '<span '.$css_comment.'>'.esc_html($num_comments).'</span>';
			} elseif ( $num_comments > 1 ) {
					$return = '<a href="' . get_comments_link() .'" '.$css_comment_link.'>'. esc_html($num_comments).'</a>';
			} else {
					$return = '<a href="' . get_comments_link() .'" '.$css_comment_link.'>'. esc_html($num_comments).'</a>';
			}
			return $return;
	}
}

/** Get Thumbnails **/
if(!function_exists('bloglayouts_get_thumb')) {
	function bloglayouts_get_thumb($thumbs_size = 'bloglayouts-normal') {
		global $post;
		$link = get_the_permalink();
		if(has_post_thumbnail()){ 
				$id_post = get_the_id();					
				$single_image = wp_get_attachment_image_src( get_post_thumbnail_id($id_post), $thumbs_size );	
				$return = '<a href="'.$link.'"><img class="bloglayouts-thumbs" src="'.$single_image[0].'" alt="'.get_the_title().'"></a>';
			} else {               
				$return = '';                 
		}
		return $return;
	}
}

/** Get Blog Thumbnails **/
if(!function_exists('bloglayouts_get_blogs_thumb')) {
	function bloglayouts_get_blogs_thumb($columns,$post_id) {
		global $post; 		
		if($columns == '1') :
			$return = bloglayouts_get_thumb('bloglayouts-blog-large');
		elseif($columns == '2') :
			$return = bloglayouts_get_thumb('bloglayouts-blog-medium');
		else :
			$return = bloglayouts_get_thumb('bloglayouts-blog-small');
		endif;	
		return $return;
	}
}	


/** Get Blog Excerpt **/
if(!function_exists('bloglayouts_get_blogs_excerpt')) {
	function bloglayouts_get_blogs_excerpt($excerpt = 'default',$readmore = 'on',$css_link = '') {
		global $post;
		if($excerpt == 'default') : 
			$return = get_the_excerpt();
		else :
			$return = substr(get_the_excerpt(), 0, $excerpt);
			if($readmore == 'on') :
				$return .= '<a class="article-read-more" href="'. get_permalink($post->ID) . '" '.$css_link.'>'.esc_html__('Read More','elementor-blog-layouts').'</a>';
			else :
				$return .= '...';
			endif;
		endif;
		return $return;
	}
}

/** Get News Excerpt **/
if(!function_exists('bloglayouts_get_news_excerpt')) {
	function bloglayouts_get_news_excerpt($excerpt = 'default',$readmore = 'on',$css_link) {
		global $post;
		if($excerpt == 'default') : 
			$return = get_the_excerpt();
		else :
			$return = substr(get_the_excerpt(), 0, $excerpt);
			if($readmore == 'on') :
				$return .= '<a class="article-read-more" href="'. get_permalink($post->ID) . '" '.$css_link.'><i class="fa fa-angle-double-right"></i></a>';
			else :
				$return .= '...';
			endif;
		endif;
		return $return;
	}
}

/** Get News Excerpt **/
if(!function_exists('bloglayouts_get_news_v2_excerpt')) {
	function bloglayouts_get_news_v2_excerpt($excerpt = 'default',$readmore = 'on',$css_link) {
		global $post;
		if($excerpt == 'default') : 
			$return = get_the_excerpt();
		else :
			$return = substr(get_the_excerpt(), 0, $excerpt);
			if($readmore == 'on') :
				$return .= '<a class="article-read-more" href="'. get_permalink($post->ID) . '" '.$css_link.'>...</a>';
			else :
				$return .= '...';
			endif;
		endif;
		return $return;
	}
}

/** Check Post Format **/
if(!function_exists('bloglayouts_check_post_format')) {
	function bloglayouts_check_post_format() {
		global $post;
		$format = get_post_format_string( get_post_format() );
		if($format == 'Video') :
			$return = '<span class="bloglayouts-format-type fa fa-play-circle-o"></span>';
		elseif($format == 'Audio') :
			$return = '<span class="bloglayouts-format-type fa fa-headphones"></span>';
		else :
			$return = '';
		endif;
		return $return;
	}
}

/** Post Social Share **/
if(!function_exists('bloglayouts_post_social_share')) {
	function bloglayouts_post_social_share($css_link) {
		
		$return = '<div class="container-social">
			<a target="_blank" href="http://www.facebook.com/sharer.php?u='.get_the_permalink().'&amp;t='.get_the_title().'" title="'.esc_html__('Click to share this post on Facebook','elementor-blog-layouts').'" '.$css_link.'><i class="fa fa-facebook"></i></a>
			<a target="_blank" href="http://twitter.com/home?status='.get_the_permalink().'" title="'.esc_html__('Click to share this post on Twitter','elementor-blog-layouts').'"><i class="fa fa-twitter" '.$css_link.'></i></a>
			<a target="_blank" href="https://plus.google.com/share?url='.get_the_permalink().'" title="'.esc_html__('Click to share this post on Google+','elementor-blog-layouts').'"><i class="fa fa-google-plus" '.$css_link.'></i></a>
			<a target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&amp;url='.get_the_permalink().'" title="'.esc_html__('Click to share this post on Linkedin','elementor-blog-layouts').'"><i class="fa fa-linkedin" '.$css_link.'></i></a></div>';
		
		return $return;
	}
}
/** Get Numeric Pagination **/
if(!function_exists('bloglayouts_posts_numeric_pagination')) {
	function bloglayouts_posts_numeric_pagination($pages = '', $range = 2,$loop,$paged,$css_current_pag_num,$css_link) {  
		 $showitems = ($range * 2)+1;  

		 if(empty($paged)) $paged = 1;

		 if($pages == '')
		 {
			 $pages = $loop->max_num_pages;
			 if(!$pages)
			 {
				 $pages = 1;
			 }
		 }   
		
		 $return = '';
		
		 if(1 != $pages) {		 	
			 $return .= "<div class='fnwp-numeric-pagination'>";
			 if($paged > 2 && $paged > $range+1 && $showitems < $pages) $return .=  "<a href='".get_pagenum_link(1)."' class=\"fnwp-pagination-numeric-arrow\" ".$css_link."><i class=\"fa fa-angle-double-left fnwp-icon-double-left\"></i></a>";
			 if($paged > 1 && $showitems < $pages) $return .=  "<a href='".get_pagenum_link($paged - 1)."' class=\"fnwp-pagination-numeric-arrow\" ".$css_link."><i class=\"fa fa-angle-left fnwp-icon-left\"></i></a>";

			 for ($i=1; $i <= $pages; $i++)
			 {
				 if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
				 {
					 $return .=  ($paged == $i)? "<span class='current' ".$css_current_pag_num.">".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' ".$css_link.">".$i."</a>";
				 }
			 }

			 if ($paged < $pages && $showitems < $pages) $return .= "<a href='".get_pagenum_link($paged + 1)."' class=\"fnwp-pagination-numeric-arrow\" ".$css_link."><i class=\"fa fa-angle-right fnwp-icon-right\"></i></a>";
			 if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) $return .=  "<a href='".get_pagenum_link($pages)."' class=\"fnwp-pagination-numeric-arrow\" ".$css_link."><i class=\"fa fa-angle-double-right fnwp-icon-double-right\"></i></a>";
			 $return .=  "</div>\n";
		 }
		 
		 return $return;
	}
}

/* Gallery Pagination */
function bloglayouts_get_gallery_pagination($num_page_for_pagination,$pagination) {
	$output = '<ul class="bloglayouts_gallery_pagination">';
	for($i=1; $i <= $num_page_for_pagination; $i++) {
		
		if($i == $pagination) {
			$output .= '<li class="mg_current">'.esc_html($i).'</li>'; // CURRENT PAGE
		} else {
			$output .= '<li><a href="'.get_post_permalink().'&mg_page='.$i.'">'.esc_html($i).'</a></li>'; // OTHER PAGE
		}
	}
	$output .= '</ul>';
	return $output;
}

/* Var Gallery Pagination */
function bloglayouts_add_query_vars_bloglayouts_gallery_pagination( $vars ){
  $vars[] = "mg_page";
  return $vars;
}
add_filter( 'query_vars', 'bloglayouts_add_query_vars_bloglayouts_gallery_pagination' );

/* Gallery Share Button */
function bloglayouts_share_button($id,$image_lightbox,$text_caption) {
	$return = '';
	$return .= '<a href="" class="fa fa-share-alt"></a>';
	$return .= '<div class="bloglayouts-gallery-social-share-container">';
		$return .= '<div class="bloglayouts-gallery-social-share-container-content">';
			$return .= '<a target="_blank" href="http://www.facebook.com/sharer.php?caption='.$text_caption.'&description='.$text_caption.'&u='.$image_lightbox.'&picture='.$image_lightbox.'"><i class="fa fa-facebook"></i></a>';
		$return .= '</div>';
	$return .= '</div>';
	return $return;
	
}

if(!function_exists('bloglayouts_query')) {
	function bloglayouts_query( $source,
						$posts_source, 
						$posts_type, 
						$categories,
						$categories_post_type,
						$order, 
						$orderby, 
						$pagination, 
						$pagination_type,
						$num_posts, 
						$num_posts_page) {
								  
						if($orderby == 'views') { 
								$orderby = 'meta_value_num'; 
								$view_order = 'views';
						} else { $view_order = ''; }	
										
						if($source == 'post_type') {
							$posts_source = 'all_posts';
						}
						
						if($posts_source == 'all_posts') {
						
							$query = 'post_type=Post&post_status=publish&ignore_sticky_posts=1&orderby='.$orderby.'&order='.$order.'';						
							
							// CUSTOM POST TYPE
							if($source == 'post_type') {
								$query .= '&post_type='.$posts_type.'';
							}

							if($view_order == 'views') { 
								$query .= '&meta_key=wpb_post_views_count';
							}
							
							// CATEGORIES POST TYPE
							if($categories_post_type != '' && !empty($categories_post_type) && $source == 'post_type') {
								$taxonomy_names = get_object_taxonomies( $posts_type );
								$query .= '&'.$taxonomy_names[0].'='.$categories_post_type.'';	
							}

							// CATEGORIES POSTS
							if($categories != '' && $categories != 'all' && !empty($categories) && $source == 'wp_posts') {
								$query .= '&category_name='.$categories.'';	
							}
								
							if($pagination == 'yes' || $pagination == 'load-more') {
								$query .= '&posts_per_page='.$num_posts_page.'';	
							} else {
								if($num_posts == '') { $num_posts = '-1'; }
								$query .= '&posts_per_page='.$num_posts.'';
							}
						
							// PAGINATION		
							if($pagination == 'yes' || $pagination == 'load-more') {
								if ( get_query_var('paged') ) {
									$paged = get_query_var('paged');
								
								} elseif ( get_query_var('page') ) {			
									$paged = get_query_var('page');			
								} else {			
									$paged = 1;			
								}			
								$query .= '&paged='.$paged.'';
							}
							// #PAGINATION	
						
						} else { // IF STICKY
							

							if($pagination == 'yes' || $pagination == 'load-more') {
								$num_posts = $num_posts_page;	
							} else {
								if($num_posts == '') { $num_posts = '-1'; }
								$num_posts = $num_posts;
							}

							// PAGINATION		
							
							if ( get_query_var('paged') ) {
								$paged = get_query_var('paged');							
							} elseif ( get_query_var('page') ) {			
								$paged = get_query_var('page');			
							} else {			
								$paged = 1;			
							}			
							
							// #PAGINATION	
												
							/* STICKY POST DA FARE ARRAY PER SCRITTURA IN ARRAY */
						
							$sticky = get_option( 'sticky_posts' );
							$sticky = array_slice( $sticky, 0, 5 );
							if($view_order == 'views') { 
								$query = array(
									'post_type' => 'post',
									'post_status' => 'publish',
									'orderby' 	=> $orderby,
									'order' => $order,
									'category_name' => $categories,
									'posts_per_page' => $num_posts,
									'meta_key' => 'wpb_post_views_count',
									'paged' => $paged, 
									'post__in'  => $sticky,
									'ignore_sticky_posts' => 1
								);
							} else {
								$query = array(
									'post_type' => 'post',
									'post_status' => 'publish',
									'orderby' 	=> $orderby,
									'order' => $order,
									'category_name' => $categories,
									'posts_per_page' => $num_posts,
									'paged' => $paged, 
									'post__in'  => $sticky,
									'ignore_sticky_posts' => 1
								);
							}						
							
						} // #all_posts
						
						return $query;	
	}
}