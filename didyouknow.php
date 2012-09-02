<?php
/**
 * @package DidYouKnow
 */
/*
Plugin Name: Did You Know
Plugin URI: 
Description:
Version: 1.0.0
Author: thedjaney2
Author URI: 
License: GPLv2 or later
*/



require_once 'widget.php';

define('DIDYOUKNOW_PLUGIN_DIR',plugins_url().'/didyouknow/');

add_action( 'widgets_init', create_function( '', 'register_widget( "DidYouKnowWidget" );' ) );
add_action( 'init', 'didyouknow_init' );
add_action( 'init', 'didyouknow_boxContent' );

add_action('wp_footer', 'didyouknow_footer');

function didyouknow_init() {



	register_post_type( 'didyouknow',
		array(
			'labels' => array(
				'name' => __( 'Did You Know?' ),
				'singular_name' => __( 'Trivia' )
			),
		'public' => false,
		'show_ui' => true,
		'has_archive' => true,
		)
	);
	
	wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');
	wp_enqueue_style('didyouknow_style',DIDYOUKNOW_PLUGIN_DIR.'style.css');
	wp_enqueue_script('didyouknow_script',DIDYOUKNOW_PLUGIN_DIR.'script.js');
		
}

function didyouknow_boxContent() {
	if(isset($_GET['didYouKnow'])){
		$id = $_GET['didYouKnow'];
		
		$args = array( 'post_type' => 'didyouknow', 'showposts' => 1,'p'=>$id );
		$loop = new WP_Query( $args );
		if ( $loop->have_posts() ) : $loop->the_post();
		?>
		<p style="font-weight:bold;"><?php the_title() ?></p>
		<?php the_content() ?>
		
		<?php
		endif;
		exit;
	}
}

function didyouknow_footer(){
	$args = array( 'post_type' => 'didyouknow', 'showposts' => 1,'orderby'=>'rand' );
	$loop = new WP_Query( $args );
	while ( $loop->have_posts() ) : $loop->the_post();
		?>
		<div id="didyouknow-slidingbox">
			<h2><?php _e( 'Did You Know?', 'did_you_know' ) ?></h2>
			<p><?php echo get_the_title(); ?></p>
			<span class="menu"><?php echo '<a title="'.__( 'Did You Know?', 'did_you_know' ).'" class="thickbox close" href="'.site_url().'?didYouKnow='.get_the_ID().'">'.__( 'Read more', 'did_you_know' ).'</a>'; ?>&nbsp;|&nbsp;<a href="javascript:void(0);" class="close"><?php _e( 'Close', 'did_you_know' ) ?></a></span>
		</div>
		<?php
	endwhile;
}