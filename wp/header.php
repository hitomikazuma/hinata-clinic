<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="description" content="<?php echo esc_attr(switch_description()); ?>">
  <title><?php echo switch_title(); ?></title>
  <link rel="icon" type="image/png" href="<?php echo esc_url(get_theme_file_uri('images/favicon.png')); ?>">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>
  <header class="header">
    <div class="inner">
      <div class="headerLogoArea">
        <img class="headerLogoBg" src="<?php echo esc_url(get_theme_file_uri('images/logo_bg.png')); ?>" alt="Hinata Clinic">
        <h1 class="headerLogo">
          <img src="<?php echo esc_url(get_theme_file_uri('images/logo.png')); ?>" alt="Hinata Clinic">
        </h1>
      </div>
      <div class="headerInfoArea">
        <nav class="headerNav">
          <ul class="headerNavList">
            <li class="headerNavItem">
              <a href="#">当院について</a>
            </li>
            <li class="headerNavItem">
              <a href="#">診療案内</a>
            </li>
            <li class="headerNavItem">
              <a href="#">予防医療</a>
            </li>
          </ul>
          <ul class="headerNavList">
            <li class="headerNavItem">
              <a href="#">診療時間・アクセス</a>
            </li>
            <li class="headerNavItem">
              <a href="#">ボランティア募集</a>
            </li>
            <li class="headerNavItem">
              <a href="#">お知らせ</a>
            </li>
          </ul>
        </nav>
        <div class="headerInfo">
          <div class="headerContact">
            <p class="headerContactText">お問い合わせは</p>
            <p class="headerContactNumber">
              <img src="<?php echo esc_url(get_theme_file_uri('images/icon_contact.png')); ?>" alt="Phone">
              0997-69-4622
            </p>
          </div>
          <div class="headerTime">
            <p class="headerTimeText">診療時間 9:30-12:00 / 14:00-18:00</p>
            <p class="headerTimeText">休診日 土日祝日</p>
          </div>
        </div>
      </div>
    </div>
  </header>