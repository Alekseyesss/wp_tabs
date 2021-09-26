<?php

namespace tabs;

use WP_Query as WP_Query;

class Tabs
{
  public function hooks()
  {
    add_action('wp_enqueue_scripts', [$this, 'register_styles']);
    add_action('wp_enqueue_scripts', [$this, 'register_scripts']);
    add_shortcode('tabs', [$this, 'tabs']);
  }
  public function tabs($atts)
  {
    wp_enqueue_style('tabs');
    wp_enqueue_script('tabs');
    $atts = shortcode_atts([
      'post_type' => 'post',
    ], $atts);
    $query = new WP_Query([
      'post_type' => $atts['post_type'],
      'orderby' => 'date',
      'order' => 'DESC',
      'posts_per_page' => 20,
    ]);
    ob_start();
    echo '<div class="tabs_wrapper"><div class="titles_wrapper">';
    if ($query->have_posts()) {
      while ($query->have_posts()) {
        $query->the_post();
        echo '<div data-post-id="' . get_the_ID() . '">';
        echo mb_strimwidth(get_the_title(), 0, 28, "...");
        echo '</div>';
      }
      wp_reset_postdata();
    }
?>
    </div>
    <div class='tabs_content'></div>
    </div>
<?php
    return ob_get_clean();
  }
  public function register_styles()
  {
    wp_register_style(
      'tabs',
      TABS_URL . '/assets/css/tabs.css'
    );
  }

  public function register_scripts()
  {
    wp_register_script(
      'tabs',
      TABS_URL . '/assets/js/tabs.js',
      [],
      false,
      true
    );
    wp_localize_script(
      'tabs',
      'tabs_arr',
      [
        'adminUrl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce(TABS_NONCE),
      ]
    );
  }
}
