<?php

/*
Plugin Name: Celery
Plugin URI: http://github.com/benallfree/celery
Description: Celery integration
Author URI: http://trycelery.com
Licence: GPLv3
Version: 1.0
*/

add_action('wp_enqueue_scripts', function() {
  wp_enqueue_script('celery-support', plugins_url('/assets/js/support.js', __FILE__));
  wp_enqueue_script('celery', 'https://www.trycelery.com/js/celery.js', null, null, true);
  wp_enqueue_script('celery-progress', 'https://www.trycelery.com/js/progress-widget.js', null, null, true);
});

require('classes/html_builder.class.php');

/*
TODO
* Progress bar only loads if campaign is enabled
* Update docs and provide shortcode example page
* 

*/

class CeleryPlugin {
  var $feed = 'https://api.twitter.com/1/statuses/user_timeline.json?screen_name=trycelery&count=10&include_rts=false';
  var $hook     = 'celery';
  var $longname  = 'Celery Settings';
  var $shortname  = 'Celery';
  var $ozhicon  = '';
  var $optionname = 'celery';
  var $homepage  = 'http://trycelery.com';
  var $filename   = '';
  var $accesslvl  = 'manage_options';
  
  function config_page_styles() {
    if (isset($_GET['page']) && $_GET['page'] == $this->hook) {
      wp_enqueue_style('clicky-admin-css', WP_CONTENT_URL . '/plugins/' . plugin_basename(dirname(__FILE__)). '/yst_plugin_tools.css');
    }
  }

  function register_settings_page() {
    add_options_page($this->longname, $this->shortname, $this->accesslvl, $this->hook, array(&$this,'config_page'));
  }
  
  function plugin_options_url() {
    return admin_url( 'options-general.php?page='.$this->hook );
  }
  
  /**
   * Add a link to the settings page to the plugins list
   */
  function add_action_link( $links, $file ) {
    static $this_plugin;
    if( empty($this_plugin) ) $this_plugin = $this->filename;
    if ( $file == $this_plugin ) {
      $settings_link = '<a href="' . $this->plugin_options_url() . '">' . __('Settings') . '</a>';
      array_unshift( $links, $settings_link );
    }
    return $links;
  }
  
  /**
   * Create a Checkbox input field
   */
  function checkbox($id, $label) {
    $options = get_option($this->optionname);
    return '<input type="checkbox" id="'.$id.'" name="'.$id.'"'. checked($options[$id],true,false).'/> <label for="'.$id.'">'.$label.'</label><br/>';
  }
  
  /**
   * Create a Text input field
   */
  function textinput($id, $label) {
    $options = get_option($this->optionname);
    return '<label for="'.$id.'">'.$label.':</label><br/><input size="45" type="text" id="'.$id.'" name="'.$id.'" value="'.$options[$id].'"/><br/><br/>';
  }

  /**
   * Create a potbox widget
   */
  function postbox($id, $title, $content) {
  ?>
    <div id="<?php echo $id; ?>" class="postbox">
      <h3 class="hndle"><span><?php echo $title; ?></span></h3>
      <div class="inside">
        <?php echo $content; ?>
      </div>
    </div>
  <?php
    $this->toc .= '<li><a href="#'.$id.'">'.$title.'</a></li>';
  }  


  /**
   * Create a form table from an array of rows
   */
  function form_table($rows) {
    $content = '<table class="form-table">';
    $i = 1;
    foreach ($rows as $row) {
      $class = '';
      if ($i > 1) {
        $class .= 'yst_row';
      }
      if ($i % 2 == 0) {
        $class .= ' even';
      }
      $content .= '<tr class="'.$row['id'].'_row '.$class.'"><th valign="top" scrope="row">';
      if (isset($row['id']) && $row['id'] != '')
        $content .= '<label for="'.$row['id'].'">'.$row['label'].':</label>';
      else
        $content .= $row['label'];
      $content .= '</th><td valign="top">';
      $content .= $row['content'];
      $content .= '</td></tr>'; 
      if ( isset($row['desc']) && !empty($row['desc']) ) {
        $content .= '<tr class="'.$row['id'].'_row '.$class.'"><td colspan="2" class="yst_desc">'.$row['desc'].'</td></tr>';
      }
        
      $i++;
    }
    $content .= '</table>';
    return $content;
  }

  /**
   * Create a "plugin like" box.
   */
  function plugin_like($hook = '') {
    if (empty($hook)) {
      $hook = $this->hook;
    }
    $content = '<p>'.__('Why not do any or all of the following:', 'celery' ).'</p>';
    $content .= '<ul>';
    $content .= '<li><a href="'.$this->homepage.'">'.__('Link to it so other folks can find out about it.', 'celery' ).'</a></li>';
    $content .= '<li><a href="http://wordpress.org/extend/plugins/'.$hook.'/">'.__('Give it a 5 star rating on WordPress.org.', 'celery' ).'</a></li>';
    $content .= '<li><a href="http://wordpress.org/extend/plugins/'.$hook.'/">'.__('Let other people know that it works with your WordPress setup.', 'celery' ).'</a></li>';
    $content .= '</ul>';
    $this->postbox($hook.'like', __( 'Like this plugin?', 'celery' ), $content);
  }  
  
  /**
   * Info box with link to the bug tracker.
   */
  function plugin_support($hook = '') {
    if (empty($hook)) {
      $hook = $this->hook;
    }
    $content = '<p>'.__("If you're in need of support for Celery and/or this plugin, please visit <a href='https://www.trycelery.com/faq'>our FAQ</a>.", 'celery').'</p>';
    $this->postbox($this->hook.'support', __('Need Support?','celery'), $content);
  }

  /**
   * Box with latest news from GetClicky
   */
  function news( ) {
    $content = <<<IFRAME
<a class="twitter-timeline" href="https://twitter.com/trycelery" data-widget-id="335419677868187648">Tweets by @trycelery</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
IFRAME;
    $this->postbox('celerylatest', __( 'Latest news from Celery' , 'celery' ), $content);
  }

  /**
   * Donation box
   */
  function donate() {
    $content = <<<CONTENT
    <p><strong>%s</strong></p>
    <form style="width:160px;margin:0 auto;" action="https://www.paypal.com/cgi-bin/webscr" method="post">
      <input type="hidden" name="cmd" value="_s-xclick">
      <input type="hidden" name="hosted_button_id" value="2JGUY2JBQSMVN">
      <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit">
      <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
    </form>
    <p>%s</p>
    <ul>
      <li><a href="https://twitter.com/share" class="twitter-share-button" data-url="http://trycelery.com" data-text="Preorders without Celery: not even once." data-related="trycelery">Tweet</a>
  <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
      <li><a href="https://facebook.com/trycelery">%s</a></li>
      <li><a href="%s">%s</a></li>
    </ul>

CONTENT;
    $content = sprintf($content,
      __( 'Want to help make it better? All donations are used to improve this plugin, so donate $10, $20 or $50 now!', 'celery' ),
      __('Or you could:', 'celery'),
      __('Like us on Facebook', 'celery'),
      admin_url('post-new.php'),
      __('Blog about us', 'celery')
    );
    $this->postbox('donate','<strong class="red">'.__( 'Like this plugin?', 'celery' ).'</strong>',$content);
  }
  
      
  function text_limit( $text, $limit, $finish = ' [&hellip;]') {
    if( strlen( $text ) > $limit ) {
        $text = substr( $text, 0, $limit );
      $text = substr( $text, 0, - ( strlen( strrchr( $text,' ') ) ) );
      $text .= $finish;
    }
    return $text;
  }


  function __construct()
  {
    add_action( 'admin_menu', array( &$this, 'register_settings_page' ) );
    $this->add_shortcodes();
    $this->admin_warnings();
  }
  
  function add_shortcodes()
  {
    $options = $this->options();
    add_shortcode('celery-connect', function($atts, $content='') use ($options) {
      if(!$atts['slug']) $atts['slug'] = $options['product_slug'];
      $selector = $atts['selector'];
      $s = <<<SCRIPT
        <script>
          jQuery(function($) {
            Celery.connect('{$selector}', '{$atts['slug']}');
          });
        </script>
SCRIPT;
      return $s;
    });

    add_shortcode('celery-inline', function($atts, $content='') use ($options) {
      if(!$atts['slug']) $atts['slug'] = $options['product_slug'];
      $atts['data-celery'] = $atts['slug'];
      unset($atts['slug']);
      $atts['data-celery-type'] = 'embed';
      $e = new HtmlElement('div-inline');
      $e->set($atts);
      return $e->build();
    });

    add_shortcode('celery-progress', function($atts, $content='') use ($options) {
      if(!$atts['slug']) $atts['slug'] = $options['product_slug'];
      if(!$atts['style']) $atts['style'] = '';
      if(!$atts['width']) $atts['width'] = "200";
      $atts['style'] .= "; width: {$atts['width']}px;";
      $atts['data-celery-slug'] = $atts['slug'];
      unset($atts['slug']);
      $atts['class'] = 'celery-progress-bar';
      if($content) $atts['data-celery-goal-text'] = $content;
      $e = new HtmlElement('div');
      $e->set($atts);
      return $e->build();
    });
    
    add_shortcode('celery-button', function($atts, $content='Order Now') use($options) {
      if(!$content) $content = 'Order Now';
      if(!$atts['slug']) $atts['slug'] = $options['product_slug'];
      $atts['data-celery'] = $atts['slug'];
      unset($atts['slug']);
      $e = new HtmlElement('button', $content);
      $e->set($atts);
      return $e->build();
    });
  }
  
  function admin_warnings()
  {
    $options = $this->options();
    if ( !$options['product_slug'] )
    {
      add_action( 'admin_notices', function() {
        require('templates/notices.php');
      });

      return;
    }
  }
  
  function config_page()
  {
    $options = $this->options();

    if ( isset( $_POST['submit'] ) ) {
      if ( !current_user_can( 'manage_options' ) ) die( __( 'You cannot edit the Celery settings.', 'celery' ) );
      check_admin_referer( 'celery-config' );

      foreach ( array( 'product_slug' ) as $option_name ) {
        if ( isset( $_POST[$option_name] ) )
          $options[$option_name] = $_POST[$option_name];
        else
          $options[$option_name] = '';
      }

      if ( $this->options() != $options ) {
        update_option( 'celery', $options );
        $message = "<p>" . __( 'Celery settings have been updated.', 'celery' ) . "</p>";
      }
    }

    if ( isset( $error ) && $error != "" ) {
      echo "<div id=\"message\" class=\"error\">$error</div>\n";
    } elseif ( isset( $message ) && $message != "" ) {
      echo "<div id=\"updatemessage\" class=\"updated fade\">$message</div>\n";
      echo "<script type=\"text/javascript\">setTimeout(function(){jQuery('#updatemessage').hide('slow');}, 3000);</script>";
    }

    require('templates/config.php');
  }
  
  function options()
  {
    $options = get_option('celery');
    if(!is_array($options))
    {
      $options = array();
    }
    return $options;
  }
  
}

$cp = new CeleryPlugin();

