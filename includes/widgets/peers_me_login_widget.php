<?

class PeersMeLogin extends WP_Widget {
    /** constructor */
    function PeersMeLogin() {
        parent::WP_Widget(false, $name = 'Peers.me Login');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        // $title = apply_filters('widget_title', $instance['title']);
        $text = apply_filters('widget_text', $instance['text']);
				$title_markup = apply_filters('widget_title', $instance['title'] );
				$title = $instance['title'];

				//check if peers.me credentials are available
				$peers_me_username = get_option ( 'peers_me_username' );
				$peers_me_password = get_option ( 'peers_me_password' );
				if(empty($peers_me_username)||empty($peers_me_password)){

					echo "Please check your API settings at the Plugin settings page:<br>";
					echo "* Peers.me API username<br>";
					echo "* Peers.me API password<br>";

				} else {
					
					// Before widget (defined by themes)
					echo $before_widget;

					// Display the widget title if one was input (before and after defined by themes)
					echo $before_title . $title_markup . $after_title;
					
					// Display a containing div ?>
					<div id="peers-me-widget">
						<p><? echo $text; ?></p>
						<p id="peers-me-widget-link" class="peers-login"><a href="http://<? echo $peers_me_username; ?>.peers.me/">login</a></p>
					</div>


					<?php 
					// After widget (defined by themes)
					echo $after_widget;
					
        ?>
<?php
			}

    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
				$instance = $old_instance;
				$instance['title'] = strip_tags($new_instance['title']);
				$instance['text'] = strip_tags($new_instance['text']);

        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {				
				if(empty($instance['title'])) $instance['title'] = "";
				if(empty($instance['text'])) $instance['text'] = "";

				$title = esc_attr($instance['title']);
				$text = esc_attr($instance['text']);

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

} 

?>