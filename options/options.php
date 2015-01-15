<?php

global $tm_theme_options;

$tm_theme_options = array();

/**
* tm Theme Options Version
*/
define( 'tm_THEME_OPTIONS_VER', '1.3' );

/**
* Set some default theme options when theme is switched to this theme
*/
function tm_theme_options_activation_func() {

    $defaults = (array) tm_get_options();

    if ( ! get_option( tm_get_current_theme_id() . "_options" ) )
        update_option( tm_get_current_theme_id() . "_options" , $defaults );

}
add_action( 'after_switch_theme', 'tm_theme_options_activation_func', 10, 2 );

/**
* Merge existing and new option arrays
*/
function tm_register_theme_options( $options ) {
    global $tm_theme_options;
    $tm_theme_options = array_merge( $tm_theme_options, $options );
}

/**
* Extract tabs array
*/
function tm_register_theme_option_tab( $args ) {
    global $tm_tabs;
    extract( $args );
    if ( $name ) :
        $tm_tabs[] = $args;
        return true;
    endif;
}

/**
 * Return current theme ID
 */
function tm_get_current_theme_id() {

    $themedata = wp_get_theme();
    $theme_title = $themedata->title;
    $theme_shortname = strtolower( preg_replace( '/ /', '_', $theme_title ) );

    return $theme_shortname;

}

/**
 * Get Theme Options Directory URI
 */
function tm_get_theme_options_directory_uri() {

  return trailingslashit( trailingslashit( get_template_directory_uri() ) . basename( dirname( __FILE__ ) ) );

}

/**
* Perform basic setup, registration, and init actions for a theme
*/
function tm_after_setup_theme() {

    include_once( 'library/theme-customizer.php' );

}
add_action( 'after_setup_theme', 'tm_after_setup_theme', 10 );

/**
* Enqueue CSS and Javascripts
*/
function tm_enqueue_scripts_styles() {

    wp_enqueue_style( 'tm-framework', tm_get_theme_options_directory_uri() . 'css/tm-framework.css' );
    wp_enqueue_script( 'tm-framework', tm_get_theme_options_directory_uri() . 'js/tm-framework.js', array( 'jquery' ) );
    wp_enqueue_script( 'wp-color-picker' );
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_media(); // for WordPress 3.5 Media Pop up
	wp_enqueue_script( 'thickbox' ); // for Font select Pop up
	wp_enqueue_style( 'thickbox' ); // for Font select Pop up

}
add_action( 'admin_print_scripts-appearance_page_tm-settings', 'tm_enqueue_scripts_styles', 40 );

/**
* Settings API options initilization and validation
*/
function tm_register_options() {
	global $wp_customize;
	if ( ! isset( $wp_customize ) ) {
		include_once( 'library/options-register.php' );
    }

}
add_action( 'admin_init', 'tm_register_options' );

/**
* Settings API actions initilization and validation
*/
function tm_register_actions() {
    include_once( 'library/actions.php' );
}
add_action( 'init', 'tm_register_actions' );

/**
* Fonts need to be included outside of action
*/
include_once( 'library/fonts.php' );
include_once( 'library/helpers.php' );
/**
 * Setup the Theme Admin Settings Page
 */
function tm_add_theme_page() {
    // Globalize Theme options page
    global $tm_settings_page;
    // Add Theme options page
    $tm_settings_page = add_theme_page(
        // $page_title
        // Name displayed in HTML title tag
        __( 'Theme Options', 'tm' ),
        // $menu_title
        // Name displayed in the Admin Menu
        __( 'Theme Options', 'tm' ),
        // $capability
        // User capability required to access page
        tm_get_settings_page_cap(),
        // $menu_slug
        // String to append to URL after "themes.php"
        'tm-settings',
        // $callback
        // Function to define settings page markup
        'tm_admin_options_page'
    );
}
add_action( 'admin_menu', 'tm_add_theme_page' );

/**
 * Settings Page Markup
 */
function tm_admin_options_page() {
    global $tm_tabs;
    // Determine the current page tab
    $currenttab = tm_get_current_tab();
    // Define the page section accordingly
    $settings_section = 'tm_' . $currenttab . '_tab';
    ?>

    <div class="wrap">
        <?php tm_get_page_tab_markup(); ?>
        <?php if ( isset( $_GET['settings-updated'] ) ) {
                if( isset ( $_GET['i'] ) ) {
                    $tabvalue = $_GET['i'];
                } else {
                    $tabvalue = 0;
                }
                $current_tab_title = tm_get_current_tab_title( $tabvalue );
                echo '<div class="updated"><p>';
                echo '<strong>' . $current_tab_title . __( ' settings updated successfully.', 'tm' ) . '</strong>';
                echo '</p></div>';
        } ?>
        <form action="options.php" method="post">
            <?php
                // Implement settings field security, nonces, etc.
                settings_fields( tm_get_current_theme_id() . '_options' );
                // Output each settings section, and each
                // Settings field in each section
                do_settings_sections( $settings_section );
            ?>
            <?php submit_button( __( 'Save Settings', 'tm' ), 'primary', tm_get_current_theme_id() . "_options[submit-{$currenttab}]", false ); ?>
            <?php submit_button( __( 'Reset Defaults', 'tm' ), 'secondary', tm_get_current_theme_id() . "_options[reset-{$currenttab}]", false ); ?>
        </form>
    </div>
<?php
}

/**
 * Default Options (multiple)
 */
function tm_get_option_defaults() {
    // Get the array that holds all
    // Theme option parameters
    $option_parameters = tm_get_option_parameters();
    // Initialize the array to hold
    // the default values for all
    // Theme options
    $option_defaults = array();
    // Loop through the option
    // parameters array
    foreach ( $option_parameters as $option_parameter ) {
        $name = $option_parameter['name'];
        // Add an associative array key
        // to the defaults array for each
        // option in the parameters array
        if( isset( $option_parameter['default'] ) )
            $option_defaults[$name] = $option_parameter['default'];
    }
    // Return the defaults array
    return $option_defaults;
}

/**
 * Default Option (single)
 *
 * Returns an associative array that holds
 * all of the default values for all Theme
 * options.
 *
 * @uses    tm_get_option_parameters() defined in \functions\options.php
 *
 * @return  string  $default single default value
 */
function tm_get_option_default( $name ) {
    // Get the array that holds all
    // Theme option parameters
    $option_parameters = tm_get_option_parameters();
    // Initialize the array to hold
    // the default values for all
    // Theme options

    $option_parameter = $option_parameters[ $name ];

    if( isset( $option_parameter['default'] ) )
        $default = $option_parameter['default'];

    return $default;
}

/**
 * Option Parameters
 *
 * Array that holds parameters for all options for
 * tm. The 'type' key is used to generate
 * the proper form field markup and to sanitize
 * the user-input data properly. The 'tab' key
 * determines the Settings Page on which the
 * option appears, and the 'section' tab determines
 * the section of the Settings Page tab in which
 * the option appears.
 *
 * @return  array   $options    array of arrays of option parameters
 */
function tm_get_option_parameters() {

    global $tm_theme_options;
    return $tm_theme_options;

}

/**
 * Get tm Theme Options
 *
 * Array that holds all of the defined values
 * for tm Theme options. If the user
 * has not specified a value for a given Theme
 * option, then the option's default value is
 * used instead.
 *
 * @uses    tm_get_option_defaults()   defined in \functions\options.php
 * @uses    get_option()
 * @uses    wp_parse_args()
 *
 * @return  array   $tm_options    current values for all Theme options
 */
function tm_get_options() {
    // Get the option defaults
    $option_defaults = tm_get_option_defaults();
    // Globalize the variable that holds the Theme options
    global $tm_options;
    // Parse the stored options with the defaults
    $tm_options = (object) wp_parse_args( get_option( tm_get_current_theme_id() . '_options', array() ), $option_defaults );
    // Return the parsed array
    return $tm_options;
}

/**
 * Separate settings by tab
 *
 * Returns an array of tabs, each of
 * which is an indexed array of settings
 * included with the specified tab.
 *
 * @uses    tm_get_option_parameters() defined in \functions\options.php
 *
 * @return  array   $settingsbytab  array of arrays of settings by tab
 */
function tm_get_settings_by_tab() {

    global $tm_tabs;

    // Initialize an array to hold
    // an indexed array of tabnames
    $settingsbytab = array();
    // Loop through the array of tabs
    foreach ( $tm_tabs as $tab ) {
        $tabname = $tab['name'];
        // Add an indexed array key
        // to the settings-by-tab
        // array for each tab name
        $tabs[] = $tabname;
    }
    // Get the array of option parameters
    $option_parameters = tm_get_option_parameters();
    // Loop through the option parameters
    // array
    foreach ( $option_parameters as $option_parameter ) {
        // Ignore "internal" type options
        if ( in_array( $option_parameter['tab'] , $tabs ) ) {
            $optiontab = $option_parameter['tab'];
            $optionname = $option_parameter['name'];
            // Add an indexed array key to the
            // settings-by-tab array for each
            // setting associated with each tab
            $settingsbytab[$optiontab][] = $optionname;
        }
    }
    // Return the settings-by-tab
    // array
    return $settingsbytab;
}

function tm_get_settings_page_cap() {
    return 'edit_theme_options';
}
// Hook into option_page_capability_{option_page}
add_action( 'option_page_capability_tm-settings', 'tm_get_settings_page_cap' );


/**
 * Fields
 */

function tm_field_text( $value, $attr ) { ?>
    <input type="text" name="<?php echo tm_get_current_theme_id(); ?>_options[<?php echo $attr['name']; ?>]" value="<?php echo esc_attr( $value ); ?>">
<?php
}

function tm_field_textarea( $value, $attr ) { ?>
    <textarea name="<?php echo tm_get_current_theme_id(); ?>_options[<?php echo $attr['name']; ?>]" cols="48" rows="8"><?php echo stripslashes_deep( $value ); ?></textarea>
<?php
}

function tm_field_select( $value, $attr ) { ?>
<select name="<?php echo tm_get_current_theme_id(); ?>_options[<?php echo $attr['name']; ?>]">
    <?php
    if ( isset( $attr['valid_options'] ) ) :
        $options = $attr['valid_options'];
        foreach( $options as $option ) :
			if( isset( $option['parameter'] ) && '' != $option['parameter'] ) {
				$opt =  $option['name'] . ':' . $option['parameter'] ;
			} else {
				$opt = $option['name'];
			}
        ?>
            <option value="<?php echo $opt; ?>" <?php selected( $opt, $value ); ?>><?php echo $option['title']; ?></option>
            <?php
        endforeach;
    else:
        _e( "This option has no valid options. Please create valid options as an array inside the tm Framework.", "tm" );
    endif;
    ?>
</select>
<?php
}

function tm_field_radio_image( $value, $attr ) { ?>
    <?php
    if ( isset( $attr['valid_options'] ) ) :
        $options = $attr['valid_options'];
        foreach( $options as $option ) :
        ?>
    <label class="radio_image">
    <input type="radio" name="<?php echo tm_get_current_theme_id(); ?>_options[<?php echo $attr['name']; ?>]" value="<?php echo $option['name']; ?>" <?php checked($option['name'], $value ); ?>>
      <?php if( $option['image'] ) echo '<img src="' . $option['image'] . '">'; ?>
    </label>
            <?php
        endforeach;
    else:
        _e( "This option has no valid options. Please create valid options as an array inside the tm Framework.", "tm" );
    endif;
    ?>
</select>
<?php
}

function tm_field_radio( $value, $attr ) { ?>
    <?php
    if ( isset( $attr['valid_options'] ) ) :
        $options = $attr['valid_options'];
        foreach( $options as $option ) :
        ?>
    <label class="radio">
      <input type="radio" name="<?php echo tm_get_current_theme_id(); ?>_options[<?php echo $attr['name']; ?>]" value="<?php echo $option['name']; ?>" <?php checked( $option['name'], $value ); ?>> <?php echo $option['title']; ?>
    </label>
            <?php
        endforeach;
    else:
        _e( "This option has no valid options. Please create valid options as an array inside the tm Framework.", "tm" );
    endif;
    ?>
</select>
<?php
}

function tm_field_checkbox( $value, $attr ) {

    if ( isset( $attr['valid_options'] ) ) :
        $options = $attr['valid_options'];

        foreach( $options as $option_key => $option_value ) : ?>
            <input class="checkbox" id ="<?php echo $attr['name']; ?>" type="checkbox" <?php if( isset( $value ) && '' != $value ) { checked( in_array( $option_value['name'], $value ) ); }  ?> name="<?php echo tm_get_current_theme_id(); ?>_options[<?php echo $attr['name']; ?>][]" value="<?php echo esc_attr( $option_key ); ?>">
             <label for="<?php echo $attr['name']; ?>"><?php echo $option_value['title'];?></label><br>
    <?php endforeach;
    endif;

}

function tm_field_color( $value, $attr ) { ?>
    <?php $defaultcolor = $attr['default']; ?>
    <span class="colorPickerWrapper">
        <input id="<?php echo $attr['name']; ?>" name="<?php echo tm_get_current_theme_id(); ?>_options[<?php echo $attr['name']; ?>]" class="color-picker" type="text" data-default-color="<?php echo $defaultcolor; ?>" value="<?php echo $value; ?>" />
    </span>

<?php
}

function tm_field_image( $value, $attr ) { ?>

    <script language="javascript">
    jQuery( document ).ready( function() {

        $container = jQuery( "#<?php echo $attr['name']; ?>_container" );
        $image_button = $container.find( '.upload_image_button' );

        $image_button.click( function() {

            // WordPress 3.5 Media Pop Up
            $this = jQuery( this );

            var file_frame;

            // Create the media frame.
            file_frame = wp.media.frames.file_frame = wp.media({
                title: 'Select Image',
                button: {
                    text: 'Use Selected Image',
                },
                multiple: true
            });

            // When an image is selected, run a callback.
            file_frame.on( 'select', function() {
                var selection = file_frame.state().get( 'selection' );
                selection.map( function( attachment ) {
                    attachment = attachment.toJSON();
                    $this.parent().find( '.upload_image_field' ).val( attachment.url ).show();
                    $this.parent().find( '.upload_image_preview' ).show();
                    $this.parent().find( '.upload_image_preview img' ).attr( 'src', attachment.url );
                });
            });

            // open the modal
            file_frame.open();
            return false;
        });

        // remove image
        $container.on( 'click', '.upload_image_remove', function() {
            jQuery( "#<?php echo $attr['name']; ?>" ).val('');
            jQuery( "#<?php echo $attr['name']; ?>" ).parent().find( 'div.upload_image_preview img' ).attr( 'src', '' );
            jQuery( "#<?php echo $attr['name']; ?>" ).parent().find( '.upload_image_preview' ).hide();
        });
        if ( $container.find( '.upload_image_field' ).val().length > 0 ) {
            $container.find( '.upload_image_preview' ).show();
        }
    });
    </script>

    <div id="<?php echo $attr['name']; ?>_container">
        <input type="text" class="upload_image_field" id="<?php echo $attr['name']; ?>" name="<?php echo tm_get_current_theme_id(); ?>_options[<?php echo $attr['name']; ?>]" value="<?php echo $value; ?>">
        <input class="upload_image_button button" type="button" value="<?php _e( 'Upload or Select Image', 'tm' ); ?>" />
        <div class="upload_image_preview"><img src="<?php echo $value; ?>" /><br /><a href="javascript:void(0);" class="upload_image_remove"><?php _e( 'Remove', 'tm' ); ?></a></div>
    </div>

<?php
}

function tm_field_gallery( $value, $attr ) {
    $images = explode( ',', $value );
    $imgarray = '';
    foreach( $images as $imageID ) {		
		$image = wp_get_attachment_image_src( $imageID );		
        $imgarray .= '<img class="eachthumbs" src="' . $image[0] . '" style="cursor:pointer;height:60px;width:auto;margin:5px 5px 0 0;"/>';
    }
    ?>

    <script language="javascript">
    jQuery(document).ready(function() {

        $container = jQuery("#<?php echo $attr['name']; ?>_container");
        $image_field = $container.find('.upload_gallery_field');
        $image_button = $container.find('.upload_gallery_button');
        $remove_button = $container.find('.tm_gallery_remove');

        $image_button.click(function() {

            // WordPress 3.5 Media Pop Up

            var file_frame;

            // Create the media frame.
            file_frame = wp.media.frames.file_frame = wp.media({
                title: 'Select Images',
                button: {
                    text: 'Use Selected Images',
                },
                multiple: 'add'
            });

            // When an image is selected, run a callback.
            file_frame.on( 'select', function() {
                hiddenids = '';
                jQuery( '.upload_gallery_preview' ).html('');
                var selection = file_frame.state().get( 'selection' );
                selection.map( function( attachment ) {
                    attachment = attachment.toJSON();
                    hiddenids += attachment.id + ',';
                    $container.find( '.upload_gallery_preview' ).show();
                    jQuery( '.upload_gallery_preview' ).append( '<img style=\"cursor:pointer;height:60px;width:auto;margin:5px 5px 0 0;\" class=\'eachthumbs\' src=\"' + attachment.url + '\"/>' );
                });
                jQuery( '.upload_gallery_preview' ).append( '<br /><a href="javascript:void(0);" class="upload_gallery_remove">Remove</a>' );
                $container.find( '.upload_gallery_field' ).val( hiddenids.substring( 0, hiddenids.length - 1 ) ).show();
            });

            // open the modal
            file_frame.open();
            return false;
        });

        jQuery( '.upload_gallery_preview' ).on( 'click', '.eachthumbs', function() { // edit gallery
            var file_frame, selection;
            var hiddenids = '';

            var hiddenids = jQuery( '.upload_gallery_field' ).val();
            var gallerysc = '[gallery ids=' + hiddenids + ']';
            file_frame = wp.media.gallery.edit( gallerysc ); // need to replace [gallery] with actual shortcode
            file_frame.on( 'update', function( selection ) {
                jQuery( '.upload_gallery_preview' ).html( '<img src=\"" . site_url() . "/wp-includes/images/wpspin.gif" . "\" />' );
                var addedgallery = wp.media.gallery.shortcode( selection ).string();
                var idarray = addedgallery.split( '=\"' );
                datanew = idarray[1].substring( 0, idarray[1].length - 2 );

                jQuery.post( ajaxurl, { action: 'tm_imageurl', ids: datanew, pid: jQuery( '.upload_gallery_field' ).val() }, function( response ) {
                    jQuery( '.upload_gallery_field' ).val( datanew );
                    jQuery( '.upload_gallery_preview' ).html( response );
                });

            });

            return false;
        });

        // remove image
        jQuery( '.upload_gallery_preview' ).on( 'click', '.upload_gallery_remove', function() {
            jQuery( '.upload_gallery_field' ).val( '' );
            jQuery( '.upload_gallery_preview' ).hide();
        });
        if ( jQuery( '.upload_gallery_field' ).val().length > 0 ) {
            jQuery( '.upload_gallery_preview' ).show();
        }
    });
    </script>

    <div id="<?php echo $attr['name']; ?>_container">
        <input type="hidden" class="upload_gallery_field" id="<?php echo $attr['name']; ?>" name="<?php echo tm_get_current_theme_id(); ?>_options[<?php echo $attr['name']; ?>]" value="<?php echo $value; ?>">
        <input class="upload_gallery_button button" type="button" value="<?php _e( 'Upload or Select Images', 'tm' ); ?>" />
        <div class="upload_gallery_preview"><?php if( '' != $value ) { echo $imgarray; ?><br /><a href="javascript:void(0);" class="upload_gallery_remove"><?php _e( 'Remove', 'tm' ); ?></a><?php } ?></div>
    </div>

<?php
}

/**
 * Image upload ajax callback
 */
function tm_image_url_callback() {
    $ids = $_POST['ids'];
    $pid = $_POST['pid'];
    update_post_meta( $pid, 'upload_gallery_preview', $ids );

    $image_ids = explode( ',', $ids );
    $all_images = '';
    foreach( $image_ids as $image_id ) {
        $image_attributes = wp_get_attachment_image_src( $image_id, 'large' ); // returns an array
        $all_images .= "<img style=\"cursor:pointer;height:60px;width:auto;margin:5px 5px 0 0;\" class=\"eachthumbs\" src=\"" . $image_attributes[0] . "\"/>";
    }
    echo $all_images;
    die();
}

add_action( 'wp_ajax_tm_imageurl', 'tm_image_url_callback' );

/**
 * Custom Font Previews
 */
function tm_fonts_preview() {

	// Flag to determine if this is for the header or body copy.
	$font_flag = $_GET['font'];

	$fonts = tm_font_array();
	$protocol = is_ssl() ? 'https' : 'http';

	$count = count( $fonts );
	$i = 0;
	$final_fonts = null;

	foreach( $fonts as $font => $attributes ) {
	    $i++;

	    if ( $count != $i ){
	        $sep = '|';
	    } else {
	        $sep = null;
	    }
	    $clean_font = str_replace(' ', '+', $font );
	    if ( ! empty( $attributes['parameter'] ) ) {
	    	$attr_sep = ':';
	    } else {
	    	$attr_sep = '';
	    }

	    $final_fonts .= "{$clean_font}{$attr_sep}{$attributes['parameter']}{$sep}";
	}

	// wp_enqueue_style( 'reportage-google-fonts', "$protocol://fonts.googleapis.com/css?family={$final_fonts}" );
	print "<link href='$protocol://fonts.googleapis.com/css?family={$final_fonts}' rel='stylesheet' type='text/css'>";

	$lorum = 'Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.';
	$html = null;

	foreach ( $fonts as $font => $attributes ) {
		$class = strtolower( str_replace( ' ' , '-', $font ) );
		$html .= '<div class="box">';
		$html .= '<h2 class="' . $class . '">' . $attributes['title'] . '</h2>';
		$html .= '<p class="' . $class . '">' . $lorum . '</p>';
        if( "" != $attributes['parameter'] ) {
            $font_attr = ':' . $attributes['parameter'];
        } else {
            $font_attr = "";
        }
		$html .= '<button class="button" data-font-' . $font_flag . '="' . $font . $font_attr . '">Use this font</button>';
		$html .= '</div>';
	}

	print '<div id="tm-font-preview">' . $html . '</div>';
	die();
}

add_action( 'wp_ajax_fonts', 'tm_fonts_preview' );

/**
 * Theme Name, Theme Version, Readme, Support utility links on theme options
 */
function tm_utility_links(){

    $theme_data = wp_get_theme();

    echo '<div class="theme-options">';
    echo '<ul>';
    echo '<li><a href="' . $theme_data->get( 'ThemeURI' ) . '" target="_blank">' . $theme_data->Name . '</a></li>';
    echo '<li>' . __( 'Version: ', 'tm' ) . $theme_data->Version . '</li>';
    echo '<li><a href="' . $theme_data->get( 'AuthorURI' ) . '" target="_blank">' . __( 'Support', 'tm' ) . '</a></li>';
    echo '<li><a href="http://techmantra.orgsupport/instructions/?theme=' . strtolower( str_replace( " ", "-", $theme_data->Name ) ) . '" title="' . __( 'Theme Instructions', 'tm' ) . '" target="_blank">' . __( 'Instructions', 'tm' ) . '</a></li>';
    echo '</ul>';
    echo '<br class="clear">';
    echo '</div>';
}

/**
* Add custom url field to media uploader 
*/

add_filter( "attachment_fields_to_edit", "tm_image_attachment_fields_to_edit", null, 2 ); 
function tm_image_attachment_fields_to_edit( $form_fields, $post ) {	
	$form_fields["tm_custom_url"]["label"] = __( "URL", "tm" );
	$form_fields["tm_custom_url"]["input"] = "text";
	$form_fields["tm_custom_url"]["value"] = get_post_meta( $post->ID, "_tm_custom_url", true );
	$form_fields["tm_custom_url"]["helps"] = "URL to link this image."; 
	return $form_fields;
}
add_filter("attachment_fields_to_save", "tm_image_attachment_fields_to_save", null, 2);
function tm_image_attachment_fields_to_save( $post, $attachment ) {	
	if( isset( $attachment['tm_custom_url'] ) ) {		
		update_post_meta( $post['ID'], '_tm_custom_url', $attachment['tm_custom_url'] );
	}
	return $post;
}