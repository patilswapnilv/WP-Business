<?php

if ( ! class_exists( 'WP_Business_Callout_Widget' ) ) :
/**
 * Create a custom widget to handle callouts
 */
class WP_Business_Callout_Widget extends WP_Widget {

    function WP_Business_Callout_Widget(){
        $widget_ops = array( 'description' => 'Displays the callout on the home page' );
        $control_ops = array( 'width' => 200, 'height' => 200 );
        parent::WP_Widget(false,$name='Home Page Callout',$widget_ops,$control_ops);
    }


    /* Displays the Widget in the front-end */
    function widget($args, $instance){
        extract($args);

        $description = apply_filters( 'widget_title', empty($instance['description']) ? '' : $instance['description'] );
        $link = apply_filters( 'widget_title', empty($instance['link']) ? '' : $instance['link'] );

        echo $before_widget;

        ?>
        <div class="WP_Business-homepage-callout-widget">
            <div class="description"><?php echo $description; ?></div>
            <a href="<?php echo $link; ?>" class="call-to-action">Call to action</a>
        </div><!-- .WP_Business-homepage-callout-widget -->
        <?php echo $after_widget;
    }


    /*Saves the settings. */
    function update($new_instance, $old_instance){
        $instance = $old_instance;
        $instance['description'] = stripslashes($new_instance['description']);
        $instance['link'] = stripslashes($new_instance['link']);

        return $instance;
    }

    /*Creates the form for the widget in the back-end. */
    function form($instance){

        $description = empty( $instance['description'] ) ? null : $instance['description'];
        $description = htmlspecialchars( $description );

        $link = empty( $instance['link'] ) ? null : $instance['link'];
        $link = htmlspecialchars( $link ); ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Description:', 'WP_Business' ); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>"><?php echo $description; ?></textarea>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link:', 'WP_Business' ); ?></label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" value="<?php echo esc_url( $link ); ?>" />
        </p>
        <?php

    }
}
endif; // WP_Business_Callout_Widget


if ( ! function_exists( 'WP_Business_WidgetInit' ) ) :
/**
 * Register the widget we created
 */
function WP_Business_WidgetInit() {
    register_widget( 'WP_Business_Callout_Widget' );
}
endif; // WP_Business_WidgetInit
add_action( 'widgets_init', 'WP_Business_WidgetInit' );