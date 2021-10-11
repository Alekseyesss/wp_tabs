<?php

namespace tabs;

use WP_Query;

class Ajax
{
  public function hooks()
  {
    add_action('wp_ajax_post-tabs', [$this, 'create_tab_content']);
    add_action('wp_ajax_nopriv_post-tabs', [$this, 'create_tab_content']);
  }
  public function create_tab_content()
  {
    check_ajax_referer(TABS_NONCE, 'security');

    if ($_POST['post_id'] === null) {
      wp_send_json_error(null, 400);
    }

    $post_id = absint($_POST['post_id']);
    $query = new WP_Query([
      "p" => $post_id,
      "post_type" => "any",
      'posts_per_page' => 1,
    ]);
    ob_start();
    if ($query->have_posts()) {
      while ($query->have_posts()) {
        $query->the_post();
?>
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
<?php
      }
      wp_reset_postdata();
    }
    $data = ob_get_clean();
    wp_send_json_success($data);
  }
}
