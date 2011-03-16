<?
/**
 * FooWidget Class
 */

// $users_path = get_option ( 'peers_me_userspath' );
// $groups_path = get_option ( 'peers_me_groupspath' );
// $publications_path = get_option ( 'peers_me_publicationspath' );
// if(empty($users_path)) $users_path = "users";
// if(empty($groups_path)) $groups_path = "groups";
// if(empty($publications_path)) $publications_path = "publications";


class PeersMeLogin extends WP_Widget {
    /** constructor */
    function PeersMeLogin() {
        parent::WP_Widget(false, $name = 'Peers.me Login');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $text = apply_filters('widget_text', $instance['text']);
				// $resource = apply_filters('widget_resource', $instance['resource']);
				// $orderby = apply_filters('widget_orderby', $instance['orderby']);
				// $order = apply_filters('widget_order', $instance['order']);
				// $link = apply_filters('widget_link', $instance['link']);
				// $label = apply_filters('widget_label', $instance['label']);

				//check if peers.me credentials are available
				$peers_me_username = get_option ( 'peers_me_username' );
				$peers_me_password = get_option ( 'peers_me_password' );
				if(empty($peers_me_username)||empty($peers_me_password)){

					echo "Please check your API settings at the Plugin settings page:<br>";
					echo "* Peers.me API username<br>";
					echo "* Peers.me API password<br>";

				} else {
        ?>
				<div id="peers-me-widget">
					<p id="peers-me-widget-title"><? echo $title; ?></p>
					<p><? echo $text; ?></p>
					<p id="peers-me-widget-link"><a href="http://<? echo $peers_me_username; ?>.peers.me/">login</a></p>
				</div>
<?php
			}

    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
				$instance = $old_instance;
				$instance['title'] = strip_tags($new_instance['title']);
				$instance['text'] = strip_tags($new_instance['text']);
				// $instance['resource'] = strip_tags($new_instance['resource']);
				// $instance['orderby'] = strip_tags($new_instance['orderby']);
				// $instance['order'] = strip_tags($new_instance['order']);
				// $instance['link'] = strip_tags($new_instance['link']);
				// $instance['label'] = strip_tags($new_instance['label']);

        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {				
				if(empty($instance['title'])) $instance['title'] = "";
				if(empty($instance['text'])) $instance['text'] = "";
				// if(empty($instance['resource'])) $instance['resource'] = "";
				// if(empty($instance['orderby'])) $instance['orderby'] = "";
				// if(empty($instance['order'])) $instance['order'] = "";
				// if(empty($instance['link'])) $instance['link'] = "";
				// if(empty($instance['label'])) $instance['label'] = "";
					 $title = esc_attr($instance['title']);
				$text = esc_attr($instance['text']);
				// $resource = esc_attr($instance['resource']);
				// $orderby = esc_attr($instance['orderby']);
				// $order = esc_attr($instance['order']);
				// $link = esc_attr($instance['link']);
				// $label = esc_attr($instance['label']);
        ?>
            <p>
							<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> 
							<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
						</p>
            <p>
							<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:'); ?> 
							<input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo $text; ?>" /></label>
						</p>	
        <?php 
    }

} // class FooWidget

?>