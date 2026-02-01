<?php
// Vite アセット読込ヘルパー（WP テーマ用）

// エントリポイント関数：環境によって読込先を切替
function vite_assets() {
  $theme_path = get_template_directory();
  $is_dev = defined('DEV_ENV') && DEV_ENV;

  if ($is_dev) {
    // 開発: dev サーバーから module で直読み（HMR 有効）
    vite_load_dev_assets('http://localhost:5175');
    return;
  }

  // 本番: 固定ファイル名のビルド済みアセットを読み込み
  vite_load_prod_assets($theme_path);
}

// 開発: Vite dev サーバーから読み込み
function vite_load_dev_assets($origin) {
  // JS側でSCSSをimportしているため、CSSは<link>で重複させない
  echo "<script src='{$origin}/@vite/client' type='module'></script>\n";
  echo "<script src='{$origin}/assets/scripts/app.js' type='module'></script>\n";
}

// 到達性チェックは行わず、DEV_ENV 時は常に dev サーバーから読み込みます

// 本番: 固定ファイル名のアセットを読み込み
function vite_load_prod_assets($theme_path) {
  $js_rel = 'scripts/script.js';
  $css_rel = 'stylesheets/style.css';

  $js_abs = "{$theme_path}/{$js_rel}";
  if (file_exists($js_abs)) {
    $js_version = filemtime($js_abs);
    wp_enqueue_script('main-js', get_template_directory_uri() . '/' . $js_rel, [], $js_version, true);

    // JS を module タイプとして読み込む（重複登録を防止）
    static $module_filter_added = false;
    if (!$module_filter_added) {
      add_filter('script_loader_tag', function ($tag, $handle, $src) {
        if ($handle === 'main-js') {
          return '<script type="module" src="' . esc_url($src) . '"></script>' . "\n";
        }
        return $tag;
      }, 10, 3);
      $module_filter_added = true;
    }
  }

  $css_abs = "{$theme_path}/{$css_rel}";
  if (file_exists($css_abs)) {
    $css_version = filemtime($css_abs);
    wp_enqueue_style('main-css', get_template_directory_uri() . '/' . $css_rel, [], $css_version);
  }
}

// WP のスクリプト読み込みに接続（早期に実行）
add_action('wp_enqueue_scripts', 'vite_assets', 1);

// 画像は get_theme_file_uri('images/...') を利用（専用ヘルパーは不要）
