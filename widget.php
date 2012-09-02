<?php
/* Classes */
class DidYouKnowWidget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'didyouknow_widget', // Base ID
			'Did You Know', // Name
			array( 'description' => __( 'Trivia Box', 'did_you_know' ), ) // Args
		);
	}



	public function widget( $args, $instance ) {
		extract( $args );
		echo $before_widget;
		
		if(isset($instance['title'])){
			$title = $instance['title'];
		}else{
			$title = 'Did You Know?';
		}
		
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
			
		$args = array( 'post_type' => 'didyouknow', 'showposts' => 1,'orderby'=>'rand' );
		$loop = new WP_Query( $args );
		while ( $loop->have_posts() ) : $loop->the_post();
			echo get_the_title().' <a title="'.$title.'" class="thickbox" href="'.site_url().'?didYouKnow='.get_the_ID().'">'.__( 'more...', 'did_you_know' ).'</a>';
		endwhile;

		echo $after_widget;
	}
	
	
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Did You Know?', 'text_domain' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}
	
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

}

/* Classes END */