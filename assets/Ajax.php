<?php

namespace ajax;

class Ajax
{
  public function hooks()
  {
    add_action('wp_ajax_post-tabs', [$this, 'foo_tabs']);
    add_action('wp_ajax_nopriv_post-tabs', [$this, 'foo_tabs']);
  }
  public function foo_tabs()
  {
    check_ajax_referer(TABS_NONCE, 'security');
    $post_id = $_POST['post_id'];
    $query = new \WP_Query(["p" => $post_id, "post_type" => "any"]);
    ob_start();
    if ($query->have_posts()) {
      while ($query->have_posts()) {
        $query->the_post();
        the_content();
        the_post_thumbnail();
      }
      wp_reset_postdata();
    }
    echo ob_get_clean();
    exit;
  }
}
