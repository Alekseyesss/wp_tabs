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
    if ($query->have_posts()) :
      $i = 0;
      while ($query->have_posts()) :
        $query->the_post();
        if ($i === 0) {
          $class = 'ba_tabs-active ba_tabs_title';
          $i = 1;
        } else {
          $class = 'ba_tabs_title';
        }
?>
        <div data-ba-post-id="<?php the_ID(); ?>" class="<?php echo $class ?>">
          <?php echo mb_strimwidth(get_the_title(), 0, 28, "..."); ?>
        </div>
      <?php
      endwhile;
      wp_reset_postdata();
    endif;
    echo '</div>';
    if ($query->have_posts()) :
      $i = 0;
      while ($query->have_posts()) :
        $query->the_post();
        if ($i === 0) {
          $class = '';
          $i = 1;
        } else {
          $class = 'ba_hide';
        }
      ?>
        <div data-ba-post-id-content="<?php the_ID(); ?>" class='ba_tabs_content <?php echo $class ?>'>
          <div class="ba_tabs_content__text">
            <div class="ba_tabs_content__text_inner">
              <div class="ba_post_title"><?php the_title(); ?></div>
              <div class="ba_post_content"><?php the_content(); ?></div>
              <a href="<?php the_permalink(); ?>" class="ba_post_button"><?php _e('Learn more', 'post-tabs'); ?></a>
            </div>
          </div>
          <div class="ba_tabs_content__img">
            <?php the_post_thumbnail(); ?>
          </div>
        </div>
    <?php
      endwhile;
      wp_reset_postdata();
    endif;
    ?>

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
  }
}
