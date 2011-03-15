<?
/**
 * FooWidget Class
 */
class PeersMePublications extends WP_Widget {
    /** constructor */
    function PeersMePublications() {
        parent::WP_Widget(false, $name = 'Peers.me publications');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        ?>
              <?php //echo $before_widget; ?>
                  <?php if ( $title )
                        // echo $before_title . $title . $after_title; ?>
												<div id="peers-me-widget">
													<p id="peers-me-widget-title"><? echo $instance['title']; ?></p>
                  <? 
$atts['limit'] = 5;
$atts['on'] = "created_at";
$atts['sort'] = "DESC";
echo peers_me_publications_index($atts,'',true); 
?>
												</div>
              <?php //echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {				
        $title = esc_attr($instance['title']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <?php 
    }

} // class FooWidget

?>