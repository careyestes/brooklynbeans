<?php
/**
 * Plugin Name: Store Locator Plus : Enhanced Map
 * Plugin URI: http://www.charlestonsw.com/product/store-locator-plus-enhanced-map/
 * Description: A premium add-on pack for Store Locator Plus that adds enhanced map UI to the plugin.
 * Version: 0.9
 * Author: Charleston Software Associates
 * Author URI: http://charlestonsw.com/
 * Requires at least: 3.3
 * Test up to : 3.5.1
 *
 * Text Domain: csa-slp-em
 * Domain Path: /languages/
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// No SLP? Get out...
//
include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
if ( !function_exists('is_plugin_active') ||  !is_plugin_active( 'store-locator-le/store-locator-le.php')) {
    return;
}

/**
 * The Enhanced Map Add-On Pack for Store Locator Plus.
 *
 * @package StoreLocatorPlus\EnhancedMap
 * @author Lance Cleveland <lance@charlestonsw.com>
 * @copyright 2012-2013 Charleston Software Associates, LLC
 */
class SLPEnhancedMap {

    //-------------------------------------
    // Properties
    //-------------------------------------


    /**
     * The directory we live in.
     *
     * @var string $dir
     */
    private $dir;

    /**
     * The minimum version of SLP that is required to use this version of Tagalong.
     *
     * Set this whenever we depend on a specific version of SLP.
     *
     * @var string $min_slp_version
     */
    private $min_slp_version        = '3.11';

    /**
     * The base class for the SLP plugin
     *
     * @var SLPlus $plugin
     **/
    public  $plugin                 = null;

    /**
     * The Enhanced Map slug.
     *
     * @var string $slug
     */
    private $slug                   = null;

    /**
     * The url to this plugin admin features.
     *
     * @var string $url
     */
    private $url;

    //------------------------------------------------------
    // METHODS
    //------------------------------------------------------

    /**
     * Invoke the Tagalong plugin.
     *
     * This ensures a singleton of this plugin.
     *
     * @static
     */
    public static function init() {
        static $instance = false;
        if ( !$instance ) {
            load_plugin_textdomain( 'csa-slp-em', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
            $instance = new SLPEnhancedMap;
        }
        return $instance;
    }

    /**
     * Constructor
     */
    function SLPEnhancedMap() {
        add_action('slp_init_complete'          ,array($this,'slp_init')                            );
        add_action('slp_admin_menu_starting'    ,array($this,'admin_menu')                          );
    }

    /**
     * After SLP initializes, do this.
     *
     * Runs on any page type where SLP is active (admin panel or UI).
     *
     * SLP Action: slp_init_complete
     *
     * @return null
     */
    function slp_init() {
        if (!$this->setPlugin()) { return; }

        // Check main plugin version is good enough.
        //
        if (version_compare(SLPLUS_VERSION, $this->min_slp_version, '<')) {
            if (is_admin()) {
                $this->plugin->notifications->add_notice(
                        4,
                        sprintf(
                            __('You have %s version %s. You need version %s or greater for this version of %s.','csa-slp-es'),
                            __('Store Locator Plus','csa-slp-em'),
                            $this->plugin->version,
                            $this->min_slp_version,
                            __('Enhanced Map'   ,'csa-slp-em')
                            )
                        );
            }
            return;
        }

        // Set Properties
        //
        $this->url = plugins_url('',__FILE__);
        $this->dir = plugin_dir_path(__FILE__);
        $this->slug = plugin_basename(__FILE__);

        // Tell SLP we are here
        //
        $this->plugin->register_addon($this->slug);

        // Hooks and Filters
        //
        add_filter('slp_map_center'                     ,array($this,'set_MapCenter')               );
        add_filter('slp_map_html'                       ,array($this,'augment_map_html')        ,10);
        add_filter('slp_shortcode_atts'                 ,array($this,'extend_main_shortcode')   ,10);

        // User Interface Elements
        //
        add_filter('slp_results_marker_data'            ,array($this,'filter_ModifyAJAXResponse'),10);
        add_filter('wpcsl_loadplugindata__slplus'       ,array($this,'filter_SetAttributeValues'),10);
    }

    /**
     * Hook into WordPress admin init when SLP admin menu is started.
     */
    function admin_menu() {
        if (!$this->setPlugin()) { return; }
        add_action('admin_init'             ,array($this,'admin_init'       )       );
    }

    /**
     * Stuff we do when SLP is ready for admin and WordPress is too.
     */
    function admin_init() {
        // WordPress Update Checker - if this plugin is active
        //
        if (is_plugin_active($this->slug)) {
            $this->metadata = get_plugin_data(__FILE__, false, false);
            if (!$this->setPlugin()) { return; }
            $this->Updates = new SLPlus_Updates(
                    $this->metadata['Version'],
                    $this->plugin->updater_url,
                    $this->slug
                    );
        }

        // Manage Location Fields
        // - tweak the add/edit form
        //
        add_filter('slp_edit_location_right_column'         ,array($this,'filter_AddFieldsToEditForm'                   ),11        );

        // Map Settings Page
        //
        add_filter('slp_map_features_settings'          ,array($this,'add_map_features_settings')        ,10);
        add_filter('slp_map_settings_settings'          ,array($this,'add_map_settings_settings')        ,10);
        add_filter('slp_save_map_settings_checkboxes'   ,array($this,'add_checkboxes_to_save')  ,10);
        add_filter('slp_save_map_settings_inputs'       ,array($this,'add_inputs_to_save')      ,10);
    }

    /**
     * Set the plugin property to point to the primary plugin object.
     *
     * Returns false if we can't get to the main plugin object.
     *
     * @global wpCSL_plugin__slplus $slplus_plugin
     * @return boolean true if plugin property is valid
     */
    function setPlugin() {
        if (!isset($this->plugin) || ($this->plugin == null)) {
            global $slplus_plugin;
            $this->plugin = $slplus_plugin;
        }
        return (isset($this->plugin) && ($this->plugin != null));
    }

    /**
     * Change the map center as specified.
     *
     * @param string $addy original address (center of country)
     * @return string
     */
    function set_MapCenter($addy) {
        // Shortcode Processing, Takes Precedence
        //
        if (!empty($this->plugin->data['center_map_at']) && (preg_replace('/\W/','',$this->plugin->data['center_map_at']) != '')) {
            $this->plugin->debugMP('msg','enhancedmap.set_MapCenter() returning ' . $this->plugin->data['center_map_at']);
            return str_replace(array("\r\n","\n","\r"),', ',esc_attr($this->plugin->data['center_map_at']));
        }
        
        // Map Settings "Center Map At"
        //
        $customAddress = get_option(SLPLUS_PREFIX.'_map_center');
        if ((preg_replace('/\W/','',$customAddress) != '')) {
            return str_replace(array("\r\n","\n","\r"),', ',esc_attr($customAddress));
        }
        return $addy;
    }

    /**
     * Add more map features settings to the admin panel.
     * 
     * @param string $html the incoming HTML
     * @return string the modified HTML
     */
    function add_map_features_settings($html) {
        if (!$this->setPlugin()) { return $html; }

        $html .=
            $this->plugin->helper->create_SubheadingLabel(__('Enhanced Map','csa-slp-em')) .
            $this->plugin->helper->CreateCheckboxDiv(
                    '-enmap_hidemap',
                    __('Hide The Map', 'csa-slp-em'),
                    __('Do not show the map on the page.','csa-slp-em')
                    ) .
            $this->plugin->helper->CreateCheckboxDiv(
                    '-show_maptoggle',
                    __('Add Map Toggle On UI', 'csa-slp-em'),
                    __('Add a map on/off toggle to the user interface.','csa-slp-em')
                    ) .
            $this->plugin->AdminUI->MapSettings->CreateInputDiv(
                    '-maptoggle_label',
                    __('Toggle Label', 'csa-slp-em'),
                    __('The text that appears before the display map on/off toggle.','csa-slp-em'),
                    SLPLUS_PREFIX,
                    __('Map','csa-slp-em')
                    )

                ;

        return $html;
    }

    /**
     * Extend the maps settings panel.
     *
     * @param string $html - original HTML string
     * @return string - augmented HTML string
     */
    function add_map_settings_settings($html) {
        if (!$this->setPlugin()) { return $html; }

            $html .=
                $this->plugin->AdminUI->MapSettings->CreateTextAreaDiv(
                        SLPLUS_PREFIX.'_map_center',
                        __('Center Map At','csa-slp-em'),
                        __('Enter an address to serve as the initial focus for the map. '               ,'csa-slp-em') .
                        __('Can be set per-page with center_map_at="address" shortcode. '               ,'csa-slp-em') .
                        __('Force JavaScript setting must be off when using the shortcode attribute. '  ,'csa-slp-em') .
                        __('Default is the center of the country.'                                      ,'csa-slp-em') ,
                        ''
                        ).

               $this->plugin->helper->create_SubheadingLabel(__('Controls','csa-slp-em')) .

               $this->plugin->helper->CreateCheckboxDiv(
                   'sl_map_overview_control',
                   __('Show Map Inset Box','csa-slp-em'),
                   __('When checked the map inset is shown.', 'csa-slp-em'),
                   ''
                   ) .
               $this->plugin->helper->CreateCheckboxDiv(
                   '_disable_scrollwheel',
                   __('Disable Scroll Wheel','csa-slp-em'),
                   __('Disable the scrollwheel zoom on the maps interface.', 'csa-slp-em')
                   ) .
               $this->plugin->helper->CreateCheckboxDiv(
                   '_disable_largemapcontrol3d',
                   __('Hide map 3d control','csa-slp-em'),
                   __('Turn the large map 3D control off.', 'csa-slp-em')
                   ) .
               $this->plugin->helper->CreateCheckboxDiv(
                   '_disable_scalecontrol',
                   __('Hide map scale','csa-slp-em'),
                   __('Turn the map scale off.', 'csa-slp-em')
                   ) .
               $this->plugin->helper->CreateCheckboxDiv(
                   '_disable_maptypecontrol',
                   __('Hide map type','csa-slp-em'),
                   __('Turn the map type selector off.', 'csa-slp-em')
                   )
               ;

        return $html;
    }

    /**
     * Augment the list of checkbox entries to save on the map settings page.
     * 
     * @param type $theArray
     */
    function add_checkboxes_to_save($theArray) {
        return array_merge(
                $theArray,
                array(
                    SLPLUS_PREFIX.'-enmap_hidemap',
                    SLPLUS_PREFIX.'-show_maptoggle',
                   'sl_map_overview_control',
                   SLPLUS_PREFIX.'_disable_scrollwheel',
                   SLPLUS_PREFIX.'_disable_largemapcontrol3d',
                   SLPLUS_PREFIX.'_disable_scalecontrol',
                   SLPLUS_PREFIX.'_disable_maptypecontrol',
                )
            );
    }

    /**
     * Augment the list of inputs to save on the map settings page.
     *
     * @param type $theArray
     */
    function add_inputs_to_save($theArray) {
        return array_merge(
                $theArray,
                array(
                    SLPLUS_PREFIX.'-maptoggle_label',
                    SLPLUS_PREFIX.'_map_center'                        
                )
                );
    }


    /**
     * Augment the default map HTML that is output.
     *
     * @param type $content
     * @return type
     */
    function augment_map_html($content) {

        // SLP 3.9.6 bug workaround?
        // TODO : Remove when SLP 3.9.7+ ships
        //
        if (!isset($this->plugin->data['hide_map']))       {  
            $this->plugin->data['hide_map'] = (
                ($this->plugin->settings->get_item('enmap_hidemap',0) == 1) ? 
                    'true' :
                    'false'
                );
        }
        if (!isset($this->plugin->data['show_maptoggle'])) {
            $this->plugin->data['show_maptoggle'] = (
                ($this->plugin->settings->get_item('show_maptoggle',0) == 1) ?
                    'true' :
                    'false'
                );
        }

        // Hiding Map?
        //
        if ($this->plugin->UI->ShortcodeOrSettingEnabled('hide_map','enmap_hidemap')) {
            return '<div id="map"></div>';
        }

        return
            $this->CreateMapDisplaySlider() .
            $content
            ;
        }

    /**
     * Render a simplified map dive that is hidden.
     *
     * Used to replace the standard map rendering with a simple hidden version.
     */
    function render_hidden_map_div() {
        if (!$this->setPlugin()) { return; }

        $content = 
            '<div id="map" ' .
                'style="display: none; visibility: hidden;"' .
                '>'.
            '</div>';

        echo apply_filters('slp_map_html',$content);
    }

    /**
     * Generate the HTML for the map on/off slider button if requested.
     *
     * @return string HTML for the map slider.
     */
    function CreateMapDisplaySlider() {
        $content =
            ($this->plugin->UI->ShortcodeOrSettingEnabled('show_maptoggle','show_maptoggle')) ?
            $this->plugin->UI->CreateSliderButton(
                    'maptoggle',
                    __('Map','csa-slp-em'),
                    !$this->plugin->UI->ShortcodeOrSettingEnabled('hide_map','enmap_hidemap'),
                    "jQuery('#map').toggle();"
                    ):
            ''
            ;
        return $content;
        }

    /**
     * Extends the main SLP shortcode approved attributes list, setting defaults.
     *
     * This will extend the approved shortcode attributes to include the items listed.
     * The array key is the attribute name, the value is the default if the attribute is not set.
     *
     * @param array $valid_atts - current list of approved attributes
     */
    function extend_main_shortcode($valid_atts) {
        if (!$this->setPlugin()) { return array(); }

        return array_merge(
                array(
                    'center_map_at'     => null,
                    'hide_map'          => null,
                    'show_maptoggle'    => null,
                    ),
                $valid_atts
            );
    }


    /**
     * Add extra fields that show in results output to the edit form.
     *
     * SLP Filter: slp_edit_location_right_column
     *
     * @param string $theForm the original HTML form for the manage locations edit (right side)
     * @return string the modified HTML form
     */
    function filter_AddFieldsToEditForm($theHTML) {
        $theHTML .=
            '<div id="slp_em_fields" class="slp_editform_section">'.
            $this->plugin->helper->create_SubheadingLabel(__('Enhanced Map','csa-slp-em'))
            ;

        // Add or Edit
        //
        $theHTML .=
            $this->plugin->AdminUI->create_InputElement(
                    'option_value[marker]',
                    __("Map Marker", 'csa-slp-em'),
                    $this->plugin->currentLocation->attributes['marker'],
                    'iconfield',
                    true
                    ).
             '<img id="location-marker" align="top" src="'.$this->plugin->currentLocation->attributes['marker'].'">' .
             $this->plugin->AdminUI->CreateIconSelector('edit-option_value[marker]','location-marker')
             ;

        $theHTML .=
            '</div>'
            ;

        return $theHTML;
    }

    /**
     * Modify the marker data.
     *
     * @param mixed[] $marker the current marker data
     */
    function filter_ModifyAJAXResponse($marker) {
        return
            array_merge(
                $marker,
                array(
                    'icon' => $marker['attributes']['marker']
                )
            );
    }

    /**
     * Tell SLP how we want to initialize our specific UI-related options.
     * 
     * @param mixed[] $atts array of arrays of setting instructions
     * @return mixed[] modified $atts array
     */
    function filter_SetAttributeValues($atts) {
        $this->plugin->debugMP('msg','enhancedmap.filter_SetAttributeValues()');
        return
            array_merge(
                $atts,
                array(
                    array(
                        'center_map_at'           ,
                        'get_option'              ,
                        array(SLPLUS_PREFIX.'_map_center','')
                      ),
                )
            );
    }
}

add_action( 'init', array( 'SLPEnhancedMap', 'init' ) );
