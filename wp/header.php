<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
  <meta name="description" content="<?php echo esc_attr(switch_description()); ?>">
  <title><?php echo switch_title(); ?></title>
  <link rel="icon" type="image/png" href="<?php echo esc_url(get_theme_file_uri('images/favicon.png')); ?>">
  <script>
  (function(d) {
    var config = {
      kitId: 'caz7vyr',
      scriptTimeout: 3000,
      async: true
    },
    h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
  })(document);
</script>
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <div class="fixedMenu">
    <p class="fixedMenuButton">
      <a href="#">
        <img src="<?php echo esc_url(get_theme_file_uri('images/icon_calendar.png')); ?>" width="29" height="31" alt="アイコン ご予約はこちらから">
        ご予約は<br>こちらから
      </a>
    </p>
    <p class="fixedMenuButton">
      <a href="#">
        <img src="<?php echo esc_url(get_theme_file_uri('images/icon_interview.png')); ?>" width="32" height="32" alt="アイコン 事前Web問診">
        事前<br>Web問診
      </a>
    </p>
    <p class="fixedMenuButton">
      <a href="#">
        <img src="<?php echo esc_url(get_theme_file_uri('images/icon_time.png')); ?>" width="20" height="20" alt="アイコン 診察時間">
        診察時間
      </a>
    </p>
  </div>

  <header class="header">
    <div class="headerInner">
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
          <div class="phone">
            <p class="phoneText">お問い合わせは</p>
            <p class="phoneNumber">
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
