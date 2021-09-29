<?php

namespace tabs;

use WP_Query;

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
      'posts_per_page' => 10,
    ]);
    ob_start();
    echo '<div class="ba_tabs_wrapper"><div class="ba_titles_wrapper">';
    if ($query->have_posts()) {
      $i = 0;
      while ($query->have_posts()) {
        $query->the_post();
        if ($i === 0) {
          $class = 'class="ba_tabs-active ba_tabs_title"';
        }
        echo '<div data-ba-post-id="' . get_the_ID() . '"' . $class . '>';
        echo mb_strimwidth(get_the_title(), 0, 28, "...");
        echo '</div>';
        $i = 1;
        $class = 'class="ba_tabs_title"';
      }
      wp_reset_postdata();
    }
?>
    </div>
    <div class='ba_tabs_content'>
      <?php
      if ($query->have_posts()) {
        $query->the_post();
      ?>
        <div class="ba_tabs_content__text">
          <div class="ba_tabs_content__text_inner">
            <div class="ba_post_title"><?php the_title(); ?></div>
            <div class="ba_post_content"><?php the_content(); ?></div>
            <a href="<?php the_permalink(); ?>" class="ba_post_button">Learn more</a>
          </div>
        </div>
        <div class="ba_tabs_content__img">
          <?php the_post_thumbnail(); ?>
        </div>
      <?php
        wp_reset_postdata();
      }
      ?>
    </div>
    </div>
<?php
    return ob_get_clean();
  }
  public function register_styles()
  {
    wp_register_style(
      'tabs',
      TABS_URL . '/assets/css/tabs.css',
      [],
      TABS_VERSION
    );
  }

  public function register_scripts()
  {
    wp_register_script(
      'tabs',
      TABS_URL . '/assets/js/tabs.js',
      [],
      TABS_VERSION,
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
