<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/*
Plugin Name: nominetuk
Plugin URI: http://www.riccardoravaro.com/
Description: Nominetuk plugin component 5
Version: 1.0
Author: Riccardo RAvaro
Author URI: http://www.riccardoravaro.com/
License: GPL2
*/


class wp_numinetuk_plugin extends WP_Widget
{

// constructor
    function __construct()
    {
        /* ... */
        $widget_ops = array(
            'classname' => 'wp_numinetuk_plugin',
            'description' => 'Add the component 5 of nominetuk test.'
        );

        parent::__construct('pu_media_upload', 'Media Upload Widget', $widget_ops);
        add_action('admin_enqueue_scripts', array($this, 'upload_scripts'));
        wp_register_style( 'component5css', plugins_url('css/style.css', __FILE__) );
        wp_enqueue_style('component5css',false, "1.1" , "all");
    }

    /**
     * Upload the Javascripts for the media uploader
     */
    public function upload_scripts()
    {
        wp_enqueue_script('media-upload'); //Provides all the functions needed to upload, validate and give format to files.
        wp_enqueue_script('thickbox'); //Responsible for managing the modal window.

        wp_enqueue_script('script', plugins_url('upload-media.js', __FILE__), array('jquery'), '', true); //It will initialize the parameters needed to show the window properly.
        wp_enqueue_style('thickbox'); //Provides the styles needed for this window.
    }

// widget form creation
    function form($instance)
    {
        /* ... */

// Check values
        if ($instance) {
            $title = esc_attr($instance['title']);
            $text = esc_attr($instance['text']);
            $textarea = esc_textarea($instance['textarea']);
            print_r($instance);

        } else {
            $title = '';
            $text = '';
            $textarea = '';

        }

        $image_url = !empty($instance['image_url']) ? $instance['image_url'] : '';
        ?>

        <p>
            <label
                for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'wp_widget_plugin'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
                   name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>"/>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Text:', 'wp_widget_plugin'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('text'); ?>"
                   name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo $text; ?>"/>
        </p>

        <p>
            <label
                for="<?php echo $this->get_field_id('textarea'); ?>"><?php _e('Textarea:', 'wp_widget_plugin'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('textarea'); ?>"
                      name="<?php echo $this->get_field_name('textarea'); ?>"><?php echo $textarea; ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'image_url' ); ?>"><?php _e( 'image_url:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'image_url' ); ?>" name="<?php echo $this->get_field_name( 'image_url' ); ?>" type="text" value="<?php echo esc_url( $image_url ); ?>" />
            <button name="upload-btn" id="upload-btn" class="upload_image_button button button-primary">Upload Image</button>
        </p>
        <?php


    }

// widget update
    function update($new_instance, $old_instance)
    {


        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['text'] = strip_tags($new_instance['text']);
        $instance['textarea'] = strip_tags($new_instance['textarea']);
        $instance['image_url'] = ( ! empty( $new_instance['image_url'] ) ) ? $new_instance['image_url'] : '';


            return $instance;

    }

// widget display
    function widget($args, $instance)
    {


        extract($args);
        // these are the widget options
        $title = apply_filters('widget_title', $instance['title']);
        $text = $instance['text'];
        $textarea = $instance['textarea'];
        $image = $instance['image_url'];
        echo $before_widget;
        // Display the widget
        $str = <<<EOF
        <div class="component v5" style="background-image:url('$image')" >
        <div class="content-wrapper-footer">
            <h3>$text</h3>
            <p>$textarea</p>
            <a class="button-more">
                FIND OUT MORE
            </a>
            </div>
        </div>

EOF;
        echo $str;
        echo $after_widget;

    }

}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("wp_numinetuk_plugin");'));