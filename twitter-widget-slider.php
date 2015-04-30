<?php

/**

 * @package twitter-widget-slider

*/

/*

Plugin Name: Twitter Widget Slider

Plugin URI: http://connexstudios.com/

Description: Twitter Widget Slider - Twitter Social Sidebar plugin.

Version: 1.0

Author: Connex Studios

Author URI: http://connexstudios.com/

*/

class TwWidgetSlider{

    

    public $options;

    

    public function __construct() {

        //you can run delete_option method to reset all data

        //delete_option('sw_twitter_plugin_options');

        $this->options = get_option('sw_twitter_plugin_options');

        $this->sw_twitter_slider_register_settings_and_fields();

    }

    

    public static function add_twitter_slider_tools_options_page(){

        add_options_page('Twitter Widget Slider', 'Twitter Widget Slider Configuration', 'administrator', __FILE__, array('TwWidgetSlider','sw_twitter_slider_tools_options'));

    }

    

    public static function sw_twitter_slider_tools_options(){

?>

<div class="wrap">

    <?php screen_icon(); ?>

    <h2>Twitter Widget Slider</h2>

    <form method="post" action="options.php" enctype="multipart/form-data">

        <?php settings_fields('sw_twitter_plugin_options'); ?>

        <?php do_settings_sections(__FILE__); ?>

        <p class="submit">

            <input name="submit" type="submit" class="button-primary" value="Save Changes"/>

        </p>

    </form>

</div>

<?php

    }

    public function sw_twitter_slider_register_settings_and_fields(){

        register_setting('sw_twitter_plugin_options', 'sw_twitter_plugin_options',array($this,'sw_twitter_validate_settings'));

        add_settings_section('sw_twitter_main_section', 'Settings', array($this,'sw_twitter_main_section_cb'), __FILE__);

        //Start Creating Fields and Options

        //pageURL

        add_settings_field('pageURL', 'Twitter Profile User Name', array($this,'pageURL_settings'), __FILE__,'sw_twitter_main_section');

        //pageURL

        add_settings_field('pageid', 'Twitter Widget ID', array($this,'pageid_settings'), __FILE__,'sw_twitter_main_section');

         //marginTop

        add_settings_field('marginTop', 'Margin Top', array($this,'marginTop_settings'), __FILE__,'sw_twitter_main_section');

        //alignment option

         add_settings_field('alignment', 'Alignment Position', array($this,'position_settings'),__FILE__,'sw_twitter_main_section');

        //width

        add_settings_field('width', 'Width', array($this,'width_settings'), __FILE__,'sw_twitter_main_section');

        //height

        add_settings_field('height', 'Height', array($this,'height_settings'), __FILE__,'sw_twitter_main_section');

        //color_scheme options

        add_settings_field('color_scheme', 'Color Theme', array($this,'color_scheme_settings'),__FILE__,'sw_twitter_main_section');

        

        //jQuery options

        

    }

    public function sw_twitter_validate_settings($plugin_options){

        return($plugin_options);

    }

    public function sw_twitter_main_section_cb(){

        //optional

    }

     //pageURL_settings

    public function pageURL_settings() {

        if(empty($this->options['pageURL'])) $this->options['pageURL'] = "BarackObama";

        echo "<input name='sw_twitter_plugin_options[pageURL]' type='text' value='{$this->options['pageURL']}' />";

    }

    //pageid_settings

    public function pageid_settings() {

        if(empty($this->options['pageid'])) $this->options['pageid'] = "470475991895138304";

        echo "<input name='sw_twitter_plugin_options[pageid]' type='text' value='{$this->options['pageid']}' />";

    }   



    //marginTop_settings

    public function marginTop_settings() {

        if(empty($this->options['marginTop'])) $this->options['marginTop'] = "100";

        echo "<input name='sw_twitter_plugin_options[marginTop]' type='text' value='{$this->options['marginTop']}' />";

    }

    

    //alignment_settings

    public function position_settings(){

        if(empty($this->options['alignment'])) $this->options['alignment'] = "left";

        $items = array('left','right');

        echo "<select name='sw_twitter_plugin_options[alignment]'>";

        foreach($items as $item){

            $selected = ($this->options['alignment'] === $item) ? 'selected = "selected"' : '';

            echo "<option value='$item' $selected>$item</option>";

        }

        echo "</select>";

    }

    //width_settings

    public function width_settings() {

        if(empty($this->options['width'])) $this->options['width'] = "292";

        echo "<input name='sw_twitter_plugin_options[width]' type='text' value='{$this->options['width']}' />";

    }

    //height_settings

    public function height_settings() {

        if(empty($this->options['height'])) $this->options['height'] = "400";

        echo "<input name='sw_twitter_plugin_options[height]' type='text' value='{$this->options['height']}' />";

    }

   

    //color_scheme_settings

    public function color_scheme_settings(){

        if(empty($this->options['color_scheme'])) $this->options['color_scheme'] = "light";

        $items = array('light','dark');

        echo "<select name='sw_twitter_plugin_options[color_scheme]'>";

        foreach($items as $item_color){

            $selected = ($this->options['color_scheme'] === $item_color) ? 'selected = "selected"' : '';

            echo "<option value='$item_color' $selected>$item_color</option>";

        }

        echo "</select>";

    }

   

    // put jQuery settings before here

}

add_action('admin_menu', 'sw_twitter_slider_trigger_options_function');



function sw_twitter_slider_trigger_options_function(){

    TwWidgetSlider::add_twitter_slider_tools_options_page();

}



add_action('admin_init','sw_twitter_slider_trigger_create_object');

function sw_twitter_slider_trigger_create_object(){

    new TwWidgetSlider();

}

add_action('wp_footer','sw_twitter_slider_add_content_in_footer');

function sw_twitter_slider_add_content_in_footer(){

    

    $o = get_option('sw_twitter_plugin_options');

    extract($o);

$print_twitter = '';

$print_twitter .= '<a class="twitter-timeline"

  href="https://twitter.com/'.$pageURL.'"

  data-widget-id="'.$pageid.'"

  data-theme="'.$color_scheme.'"

  data-link-color="#dedede"

  width="'.$width.'"

  height="400">

</a>

  

</a>';

$imgURL = plugins_url('twitter-widget-slider/assets/twitter-icon.png');

?>


<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>


<?php if($alignment=='left'){?>

<div id="sw_twitter_display">

    <div id="tsbox1" style="left: -<?php echo trim($width+10);?>px; top: <?php echo $marginTop;?>px; z-index: 10000; height:<?php echo trim($height+10);?>px;">

        <div id="tsbox2" style="text-align: left;width:<?php echo trim($width);?>px;height:<?php echo trim($height);?>px;">

            <a class="open" id="fblink" href="#"></a><img style="top: 0px;right:-49px;" src="<?php echo $imgURL;?>" alt="">

            <?php echo $print_twitter; ?>

        </div>

    </div>

</div>

<script type="text/javascript">

jQuery.noConflict();

jQuery(function (){

jQuery(document).ready(function()

{

jQuery.noConflict();

jQuery(function (){

jQuery("#tsbox1").hover(function(){ 

jQuery('#tsbox1').css('z-index',101009);

jQuery(this).stop(true,false).animate({left:  0}, 500); },

function(){ 

    jQuery('#tsbox1').css('z-index',10000);

    jQuery("#tsbox1").stop(true,false).animate({left: -<?php echo trim($width+10); ?>}, 500); });

});}); });

jQuery.noConflict();

</script>

<?php } else { ?>

<div id="sw_twitter_display">

    <div id="tsbox1" style="right: -<?php echo trim($width+10);?>px; top: <?php echo $marginTop;?>px; z-index: 10000; height:<?php echo trim($height+10);?>px;">

        <div id="tsbox2" style="text-align: left;width:<?php echo trim($width);?>px;height:<?php echo trim($height);?>px;">

            <a class="open" id="fblink" href="#"></a><img style="top: 0px;left:-49px;" src="<?php echo $imgURL;?>" alt="">

            <?php echo $print_twitter; ?>

        </div>

    </div>

</div>

<script type="text/javascript">

jQuery.noConflict();

jQuery(function (){

jQuery(document).ready(function()

{

jQuery.noConflict();

jQuery(function (){

jQuery("#tsbox1").hover(function(){ 

jQuery('#tsbox1').css('z-index',101009);

jQuery(this).stop(true,false).animate({right:  0}, 500); },

function(){ 

    jQuery('#tsbox1').css('z-index',10000);

    jQuery("#tsbox1").stop(true,false).animate({right: -<?php echo trim($width+10); ?>}, 500); });

});}); });

jQuery.noConflict();

</script>

<?php } ?>

<?php

}

add_action( 'wp_enqueue_scripts', 'register_sw_twitter_slider_likebox_sidebar_styles' );

 function register_sw_twitter_slider_likebox_sidebar_styles() {

    wp_register_style( 'register_sw_twitter_slider_likebox_sidebar_styles', plugins_url( 'assets/style.css' , __FILE__ ) );

    wp_enqueue_style( 'register_sw_twitter_slider_likebox_sidebar_styles' );

        wp_enqueue_script('jquery');

 }

 $sw_twitter_slider_default_values = array(

     'sidebarImage' => 'twitter-icon.png',

     'marginTop' => 100,

     'pageURL' => 'BarackObama',

     'page' => '115922316096420379836',

     'width' => '292',

     'height' => '400',

     'alignment' => 'left'

  

 );

 add_option('sw_twitter_plugin_options', $sw_twitter_slider_default_values);