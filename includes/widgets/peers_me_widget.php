<?
/**
 * PeersMe widget for showing Peers.me resources
 */

class PeersMe extends WP_Widget {
    /** constructor */
    function PeersMe() {
        parent::WP_Widget(false, $name = 'Peers.me');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        $limit = apply_filters('widget_limit', $instance['limit']);
				$resource = apply_filters('widget_resource', $instance['resource']);
				$orderby = apply_filters('widget_orderby', $instance['orderby']);
				$order = apply_filters('widget_order', $instance['order']);
				$link = apply_filters('widget_link', $instance['link']);
				$label = apply_filters('widget_label', $instance['label']);

				$users_path = get_option ( 'peers_me_userspath' );
				$groups_path = get_option ( 'peers_me_groupspath' );
				$publications_path = get_option ( 'peers_me_publicationspath' );

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
				<? 
				$atts['limit'] = $limit;
				$atts['on'] = $orderby;
				$atts['sort'] = $order;
				$atts['label'] = $label;
				if($resource == "users") echo peers_me_users_index($atts); 
				if($resource == "groups") echo peers_me_groups_index($atts); 
				if($resource == "publications") echo peers_me_publications_index($atts,"",true); 
				if($link == true && $resource == "users" && !empty($users_path)) echo "<p id=\"peers-me-widget-link\"><a href=\"/".$users_path."\">all users</a></p>";
				if($link == true && $resource == "groups" && !empty($groups_path)) echo "<p id=\"peers-me-widget-link\"><a href=\"/".$groups_path."\">all groups</a></p>";
				if($link == true && $resource == "publications" && !empty($publications_path)) echo "<p id=\"peers-me-widget-link\"><a href=\"/".$publications_path."\">all publications</a></p>";
				?>
				</div>
<?php
			}

    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {				
				$instance = $old_instance;
				$instance['title'] = strip_tags($new_instance['title']);
				$instance['limit'] = strip_tags($new_instance['limit']);
				$instance['resource'] = strip_tags($new_instance['resource']);
				$instance['orderby'] = strip_tags($new_instance['orderby']);
				$instance['order'] = strip_tags($new_instance['order']);
				$instance['link'] = strip_tags($new_instance['link']);
				$instance['label'] = strip_tags($new_instance['label']);

        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {				
				if(empty($instance['title'])) $instance['title'] = "";
				if(empty($instance['limit'])) $instance['limit'] = "";
				if(empty($instance['resource'])) $instance['resource'] = "";
				if(empty($instance['orderby'])) $instance['orderby'] = "";
				if(empty($instance['order'])) $instance['order'] = "";
				if(empty($instance['link'])) $instance['link'] = "";
				if(empty($instance['label'])) $instance['label'] = "";
        $title = esc_attr($instance['title']);
				$limit = esc_attr($instance['limit']);
				$resource = esc_attr($instance['resource']);
				$orderby = esc_attr($instance['orderby']);
				$order = esc_attr($instance['order']);
				$link = esc_attr($instance['link']);
				$label = esc_attr($instance['label']);
        ?>
            <p>
							<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> 
							<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
						</p>
            <p>
							<label for="resource"><?php _e('Choose resource:'); ?>
							<select class="widefat" name="<?php echo $this->get_field_name('resource'); ?>" id="<?php echo $this->get_field_id('resource'); ?>" size="1">
								<option value="users"<? if($resource == "users") echo " selected"; ?>>Users</option>
								<option value="groups"<? if($resource == "groups") echo " selected"; ?>>Groups</option>
								<option value="publications"<? if($resource == "publications") echo " selected"; ?>>Publications</option>
							</select>
							</label>
						</p>
            <p>
							<label for="<?php echo $this->get_field_id('label'); ?>"><?php _e('Show groups with label:'); ?> 
							<input class="widefat" id="<?php echo $this->get_field_id('label'); ?>" name="<?php echo $this->get_field_name('label'); ?>" type="text" value="<?php echo $label; ?>" /></label>
						</p>						
            <p>
							<label for="orderby"><?php _e('Order by:'); ?>
							<select class="widefat" name="<?php echo $this->get_field_name('orderby'); ?>" id="<?php echo $this->get_field_id('orderby'); ?>" size="1">
								<option value="created_at"<? if($orderby == "users") echo " selected"; ?>>Created at</option>
								<option value="name"<? if($orderby == "groups") echo " selected"; ?>>Name</option>
							</select>
							</label>
						</p>
            <p>
							<label for="order"><?php _e('Order:'); ?>
							<select class="widefat" name="<?php echo $this->get_field_name('order'); ?>" id="<?php echo $this->get_field_id('order'); ?>" size="1">
								<option value="DESC"<? if($order == "DESC") echo " selected"; ?>>Descending</option>
								<option value="ASC"<? if($order == "ASC") echo " selected"; ?>>Ascending</option>
							</select>
							</label>
						</p>
            <p>
							<label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Limit on (max. total):'); ?>
							<input class="widefat" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" type="text" value="<?php echo $limit; ?>" /></label>
						</p>
            <p>
	            <p>
								<label for="<?php echo $this->get_field_id('link'); ?>"><?php _e('Read more link?:'); ?>
									<input type="checkbox" name="<?php echo $this->get_field_name('link'); ?>" value="true"<? if($link == "true") echo " checked"; ?>>
								</label>
							</p>
	            <p>

						</p>
						
        <?php 
    }

}

?>