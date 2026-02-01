<?php

/**
 * テーマの機能とヘルパー関数
 *
 * Viteによるアセット管理ヘルパーを読み込みます
 */

// =====================================
// 開発環境の検出と定義
// - ローカルホストでアクセスされた場合に DEV_ENV を有効化
// =====================================
if (!defined('DEV_ENV')) {
  $env_type = function_exists('wp_get_environment_type') ? wp_get_environment_type() : '';
  $is_dev_env = in_array($env_type, ['local', 'development'], true);
  if (!$is_dev_env) {
    $host = $_SERVER['HTTP_HOST'] ?? '';
    $is_dev_env = in_array($host, ['localhost', 'localhost:8888', '127.0.0.1', '::1'], true);
  }
  define('DEV_ENV', $is_dev_env);
}

// =====================================
// 開発環境での最適化
// - ブラウザキャッシュ抑止
// - スクリプト連結オフ
// - アセットURLにタイムスタンプ付与（Vite配信は除外）
// =====================================
if (defined('DEV_ENV') && DEV_ENV) {
  // ブラウザキャッシュを無効化
  add_action('send_headers', function () {
    if (is_admin() || wp_doing_ajax() || wp_doing_cron()) {
      return;
    }
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
  });

  // WordPressのスクリプト連結を無効化（個別ファイルの変更検知を改善）
  if (!defined('CONCATENATE_SCRIPTS')) {
    define('CONCATENATE_SCRIPTS', false);
  }

  // アセットのバージョンを常に最新に
  add_filter('style_loader_src', 'remove_version_query_var', 15, 1);
  add_filter('script_loader_src', 'remove_version_query_var', 15, 1);

  function remove_version_query_var($src) {
    if (is_admin()) {
      return $src;
    }
    // Vite開発サーバーのURL(517x)はそのまま
    if (strpos($src, 'localhost:517') !== false || strpos($src, '127.0.0.1:517') !== false) {
      return $src;
    }
    // その他のアセットはタイムスタンプでキャッシュ無効化
    $parts = explode('?', $src);
    return $parts[0] . '?t=' . time();
  }
}

// =====================================
// Viteヘルパーの読み込み
// - 開発/本番のアセット読込を一元化
// =====================================
require_once get_template_directory() . '/lib/viteHelper.php';

// =====================================
// wp_head の不要出力や絵文字等を一括で削除
// =====================================
foreach (
  [
    ['wp_head', 'wp_generator'],
    ['wp_head', 'index_rel_link'],
    ['wp_head', 'rsd_link'],
    ['wp_head', 'wlwmanifest_link'],
    ['wp_head', 'rest_output_link_wp_head'],
    ['wp_head', 'feed_links', 2],
    ['wp_head', 'feed_links_extra', 3],
    ['wp_head', 'print_emoji_detection_script', 7],
    ['wp_head', 'adjacent_posts_rel_link_wp_head', 10],
    ['wp_head', 'wp_shortlink_wp_head', 10],
    ['admin_print_styles', 'print_emoji_styles'],
    ['admin_print_scripts', 'print_emoji_detection_script'],
    ['wp_print_styles', 'print_emoji_styles'],
  ] as $r
) {
  remove_action($r[0], $r[1], $r[2] ?? 10);
}

// 不要なフィルターの除去
foreach (
  [
    ['term_description', 'wpautop'],
    ['the_content_feed', 'wp_staticize_emoji'],
    ['comment_text_rss', 'wp_staticize_emoji'],
    ['wp_mail', 'wp_staticize_emoji_for_email'],
  ] as $f
) {
  remove_filter($f[0], $f[1]);
}

// TinyMCE から絵文字プラグインを外す
function disable_emojis_tinymce($plugins) {
  if (is_array($plugins)) {
    return array_diff($plugins, array('wpemoji'));
  }
  return $plugins;
}

// 基本フィルター
add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
add_filter('show_admin_bar', '__return_false');

// dns-prefetch の削除（外部先プリフェッチを抑止）
add_filter('wp_resource_hints', function ($hints, $relation_type) {
  if ($relation_type === 'dns-prefetch') return [];
  return $hints;
}, 10, 2);

// Recent Comments ウィジェットのインラインスタイルを抑止
add_action('widgets_init', function () {
  global $wp_widget_factory;
  remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
});

// 不要な oEmbed スクリプトの削除
add_action('wp_footer', function () {
  wp_deregister_script('wp-embed');
});

// jQuery Migrate をフロントから除外
add_action('wp_default_scripts', function ($scripts) {
  if (!is_admin() && isset($scripts->registered['jquery'])) {
    $script = $scripts->registered['jquery'];
    if ($script->deps) {
      $script->deps = array_diff($script->deps, array('jquery-migrate'));
    }
  }
});

// テーマ機能
// - アイキャッチ、HTML5 マークアップ、レスポンシブ埋め込み
add_theme_support('post-thumbnails');
add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script']);
add_theme_support('responsive-embeds');
// ページタイトルはWPに任せる（<title>の自前出力は不要）
add_theme_support('title-tag');


// テーマの基本スタイル/スクリプト
add_action('wp_enqueue_scripts', function () {
  // テーマのメインスタイル（wp/style.css）
  $base_style_path = get_stylesheet_directory() . '/style.css';
  $base_style_ver = file_exists($base_style_path) ? filemtime($base_style_path) : null;
  wp_enqueue_style('hinata-clinic-theme-style', get_stylesheet_uri(), [], $base_style_ver);

  // Vite のアセット読込と二重実行を避ける
  // - 開発(DEV_ENV)では Vite から直接出力されるため読み込まない
  // - 本番では viteHelper が 'main-js' を enqueue 済みなら読み込まない
  if ((defined('DEV_ENV') && DEV_ENV) || wp_script_is('main-js', 'enqueued')) {
    return;
  }

  // フォールバック: Vite を使わない構成の場合のみ読み込む
  $script_path = get_stylesheet_directory() . '/scripts/script.js';
  if (file_exists($script_path)) {
    wp_enqueue_script(
      'hinata-clinic-theme-script',
      get_stylesheet_directory_uri() . '/scripts/script.js',
      [],
      '1.0.0',
      true
    );
  }
}, 20);


// ブロックエディタ（編集画面）専用のスタイルを読み込み
add_action('enqueue_block_editor_assets', function () {
  $theme_dir = get_stylesheet_directory();
  $theme_uri = get_stylesheet_directory_uri();

  $editor_css_rel = '/editor-style.css';
  $editor_css_abs = $theme_dir . $editor_css_rel;
  if (file_exists($editor_css_abs)) {
    wp_enqueue_style('editor-style', $theme_uri . $editor_css_rel, array('wp-edit-blocks'), filemtime($editor_css_abs));
  }
});

// bodyタグにクラス（ページ名）を追加
add_filter('body_class', function ($classes) {
  if (is_page()) {
    $page = get_post();
    $classes[] = $page->post_name;
  }
  return $classes;
});

// タイトル出力（必要に応じて編集）
function switch_title() {
  $pipe = ' | ';
  $site_title = get_bloginfo('name') ?: 'ひなたクリニック';
  if (is_front_page() || is_home()) {
    return $site_title . ' ' . 'ホーム';
  }

  if (is_page()) {
    return get_the_title() . $pipe . $site_title;
  }
  if (is_404()) {
    return '404';
  }
  return $site_title;
}

// descriptionの設定
// ディスクリプション出力（必要に応じて編集）
function switch_description() {
  $site_description = get_bloginfo('description') ?: 'ひなたクリニックの公式サイトです。';

  $format_excerpt = static function (?int $post_id) use ($site_description): string {
    $excerpt = '';
    if ($post_id) {
      $excerpt = (string) get_the_excerpt($post_id);
    }

    $excerpt = wp_strip_all_tags($excerpt);
    $excerpt = preg_replace('/\s+/u', ' ', $excerpt);
    $excerpt = trim($excerpt);

    if ($excerpt === '') {
      return $site_description;
    }

    if (function_exists('mb_substr')) {
      return mb_substr($excerpt, 0, 160, 'UTF-8');
    }

    return substr($excerpt, 0, 160);
  };

  if (is_front_page() || is_home()) {
    return 'ひなたクリニックの公式サイトです。';
  }

  if (is_page()) {
    return $format_excerpt(get_queried_object_id());
  }

  if (is_singular()) {
    return $format_excerpt(get_queried_object_id());
  }

  if (is_404()) {
    return '404';
  }

  return $site_description;
}

// OGP の基本メタ出力（必要に応じて編集/拡張）
function add_ogp() {
  $site_name = get_bloginfo('name');
  $site_description = get_bloginfo('description');
  $home_url = home_url('/');

  // デフォルトOGP画像（存在チェックの上で設定）
  $default_image_uri = '';
  $default_image_path = get_theme_file_path('images/ogp.webp');
  if (file_exists($default_image_path)) {
    $default_image_uri = get_theme_file_uri('images/ogp.webp');
  }

  if (is_front_page() || is_home()) {
    $title = $site_name;
    $description = $site_description;
    $url = $home_url;
    $ogp = $default_image_uri;
    $type = 'website';
  } elseif (is_singular()) {
    $title = wp_get_document_title();
    $description = switch_description();
    $url = get_permalink();
    $thumb = get_the_post_thumbnail_url(get_queried_object_id(), 'full');
    $ogp = $thumb ? $thumb : $default_image_uri;
    $type = is_singular('post') ? 'article' : 'website';
  } else {
    $title = wp_get_document_title();
    $description = $site_description;
    $url = (is_category() || is_tag() || is_tax()) ? get_term_link(get_queried_object()) : $home_url;
    if (is_wp_error($url)) $url = $home_url;
    $ogp = $default_image_uri;
    $type = 'website';
  }
?>
  <meta property="og:title" content="<?php echo esc_attr($title); ?>">
  <meta property="og:site_name" content="<?php echo esc_attr($site_name); ?>">
  <meta property="og:description" content="<?php echo esc_attr($description); ?>">
  <meta property="og:url" content="<?php echo esc_url($url); ?>">
  <?php if ($ogp) : ?>
    <meta property="og:image" content="<?php echo esc_url($ogp); ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
  <?php endif; ?>
  <meta property="og:type" content="<?php echo esc_attr($type); ?>">
  <meta property="og:locale" content="ja_JP">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:site" content="">
<?php
}
add_action('wp_head', 'add_ogp');

// robots制御（検索結果/404はnoindex）
add_action('wp_head', function () {
  if (is_search()) {
    echo "<meta name=\"robots\" content=\"noindex,follow\">\n";
  } elseif (is_404()) {
    echo "<meta name=\"robots\" content=\"noindex,nofollow\">\n";
  }
});

// canonical の出力
add_action('wp_head', function () {
  if (is_404() || is_search()) return;

  $canonical_url = '';
  if (is_singular()) {
    $canonical_url = get_permalink();
  } elseif (is_front_page()) {
    $canonical_url = home_url('/');
  } elseif (is_home()) { // 投稿一覧
    $page_for_posts = get_option('page_for_posts');
    $base = $page_for_posts ? get_permalink($page_for_posts) : home_url('/');
    $paged = get_query_var('paged') ?: 0;
    $canonical_url = $paged ? get_pagenum_link($paged) : $base;
  } elseif (is_category() || is_tag() || is_tax()) {
    $term_link = get_term_link(get_queried_object());
    if (!is_wp_error($term_link)) {
      $paged = get_query_var('paged') ?: 0;
      $canonical_url = $paged ? get_pagenum_link($paged) : $term_link;
    }
  } elseif (is_post_type_archive()) {
    $post_type = get_query_var('post_type');
    if ($post_type) {
      $base = get_post_type_archive_link($post_type);
      $paged = get_query_var('paged') ?: 0;
      $canonical_url = $paged ? get_pagenum_link($paged) : $base;
    }
  } elseif (is_author()) {
    $author_id = get_queried_object_id();
    $base = get_author_posts_url($author_id);
    $paged = get_query_var('paged') ?: 0;
    $canonical_url = $paged ? get_pagenum_link($paged) : $base;
  } elseif (is_date()) {
    $paged = get_query_var('paged') ?: 0;
    $canonical_url = $paged ? get_pagenum_link($paged) : home_url(add_query_arg([], '/'));
  }

  if ($canonical_url) {
    echo '<link rel="canonical" href="' . esc_url($canonical_url) . '" />' . "\n";
  }
}, 9);
