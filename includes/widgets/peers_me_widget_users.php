<?
/**
 * FooWidget Class
 */
class PeersMeUsers extends WP_Widget {
    /** constructor */
    function PeersMeUsers() {
        parent::WP_Widget(false, $name = 'Peers.me users');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $limit = apply_filters('widget_limit', $instance['limit']);
				// $sort = apply_filters('widget_sort', $instance['sort']);
        ?>
              <?php //echo $before_widget; ?>
                  <?php if ( $title )
                        //echo $before_title . $title . $after_title; ?>
												<div id="peers-me-widget">
													<p id="peers-me-widget-title"><? echo $title; ?></p>
                  <? 
$atts['limit'] = $limit;
$atts['on'] = "created_at";
$atts['sort'] = "DESC";
echo peers_me_users_index($atts); 
?>
												</div>
              <?php //echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
				$instance = $old_instance;
				$instance['title'] = strip_tags($new_instance['title']);
				$instance['limit'] = strip_tags($new_instance['limit']);
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {				
        $title = esc_attr($instance['title']);
				$limit = esc_attr($instance['limit']);
				$resource = esc_attr($instance['resource']);
        ?>
            <p>
							<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> 
							<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
						</p>
            <p>
							<label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Limit:'); ?>
							<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label>
						</p>
            <p>
							<label for="<?php echo $this->get_field_id('resource'); ?>"><?php _e('Choose resource:'); ?>
							<select class="widefat" name="resource" id="resource" size="1">
								<option value="users">Users</option>
								<option value="groups">Groups</option>
								<option value="publications">Publications</option>
							</select>
							</label>
						</p>
						
        <?php 
    }

} // class FooWidget

?>