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
        h = d.documentElement,
        t = setTimeout(function() {
          h.className = h.className.replace(/\bwf-loading\b/g, "") + " wf-inactive";
        }, config.scriptTimeout),
        tk = d.createElement("script"),
        f = false,
        s = d.getElementsByTagName("script")[0],
        a;
      h.className += " wf-loading";
      tk.src = 'https://use.typekit.net/' + config.kitId + '.js';
      tk.async = true;
      tk.onload = tk.onreadystatechange = function() {
        a = this.readyState;
        if (f || a && a != "complete" && a != "loaded") return;
        f = true;
        clearTimeout(t);
        try {
          Typekit.load(config)
        } catch (e) {}
      };
      s.parentNode.insertBefore(tk, s)
    })(document);
  </script>
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <svg class="waveDefs" aria-hidden="true" focusable="false" xmlns="http://www.w3.org/2000/svg">
    <defs>
      <path id="waveShape" fill="currentColor" d="M-363.852,502.589c0,0,236.988-41.997,505.475,0s371.981,38.998,575.971,0s293.985-39.278,505.474,5.859s493.475,48.368,716.963-4.995v20000H-363.852V502.589z" />
    </defs>
  </svg>

  <div class="fixedMenu">
    <p class="fixedMenuButton">
      <a href="#">
        <img src="<?php echo esc_url(get_theme_file_uri('images/icon_calendar.png')); ?>" width="29" height="31" alt="アイコン ご予約はこちらから">
        <span class="isDesktop">ご予約は<br>こちらから</span>
        <span class="isMobile">Web予約</span>
      </a>
    </p>
    <p class="fixedMenuButton">
      <a href="#">
        <img src="<?php echo esc_url(get_theme_file_uri('images/icon_interview.png')); ?>" width="32" height="32" alt="アイコン 事前Web問診">
        <span class="isDesktop">事前<br>Web問診</span>
        <span class="isMobile">事前問診</span>
      </a>
    </p>
    <p class="fixedMenuButton">
      <a href="#">
        <img src="<?php echo esc_url(get_theme_file_uri('images/icon_time.png')); ?>" width="20" height="20" alt="アイコン 診察時間">
        <span>診察時間</span>
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
      <button class="headerMenuButton">
        <div>
          <span class="headerMenuButtonLine"></span>
          <span class="headerMenuButtonLine"></span>
        </div>
        <span class="headerMenuButtonText">Menu</span>
      </button>
      <div class="headerInfoArea">
        <nav class="headerNav">
          <ul class="headerNavList">
            <li class="headerNavItem">
              <a href="#">
                当院について
                <svg 
 xmlns="http://www.w3.org/2000/svg"
 xmlns:xlink="http://www.w3.org/1999/xlink"
 width="20px" height="20px" viewBox="0 0 20 20">
<path fill-rule="evenodd"  stroke-width="2px" stroke="rgb(11, 158, 206)" fill="rgb(11, 158, 206)"
 d="M15.182,10.014 L4.819,4.816 L4.819,15.212 L15.182,10.014 Z"/>
</svg>
              </a>
            </li>
            <li class="headerNavItem">
            <a class="isDesktop" href="#">診療案内</a>
              <button class="isMobile" type="button">
                <div class="headerNavParent">
                診療案内
                <svg 
 xmlns="http://www.w3.org/2000/svg"
 xmlns:xlink="http://www.w3.org/1999/xlink"
 width="23px" height="23px" viewBox="0 0 23 23">
<text kerning="auto" font-family="Kozuka Gothic Pr6N" fill="rgb(0, 0, 0)" transform="matrix( 1.755, 0, 0, 1.75499988913536,3.42875500000002, 19.6791769833153)" font-size="16px"><tspan font-size="16px" font-family="ShueiMGoStd" fill="#0B9ECE">&#43;</tspan></text>
<text kerning="auto" font-family="Kozuka Gothic Pr6N" stroke-width="1px" stroke="rgb(11, 158, 206)" fill-opacity="0" stroke-opacity="1" transform="matrix( 1.755, 0, 0, 1.75499988913536,3.42875500000002, 19.6791769833153)" font-size="16px"><tspan font-size="16px" font-family="ShueiMGoStd" fill="#0B9ECE">&#43;</tspan></text>
</svg>
                </div>
              </button>
              <div class="headerNavSub">
                  <p class="headerNavSubItem">
                    <a class="headerNavSubLink" href="#">一般内科</a>
                  </p>
                  <p class="headerNavSubItem">
                    <a class="headerNavSubLink" href="#">小児科</a>
                  </p>
                  <p class="headerNavSubItem">
                    <a class="headerNavSubLink" href="#">外科・整形外科</a>
                  </p>
                  <p class="headerNavSubItem">
                    <a class="headerNavSubLink" href="#">在宅医療</a>
                  </p>
                </div>
            </li>
            <li class="headerNavItem">
              <a class="isDesktop" href="#">予防医療</a>
              <button class="isMobile" type="button">
                <div class="headerNavParent">
                予防医療
                <svg 
 xmlns="http://www.w3.org/2000/svg"
 xmlns:xlink="http://www.w3.org/1999/xlink"
 width="23px" height="23px" viewBox="0 0 23 23">
<text kerning="auto" font-family="Kozuka Gothic Pr6N" fill="rgb(0, 0, 0)" transform="matrix( 1.755, 0, 0, 1.75499988913536,3.42875500000002, 19.6791769833153)" font-size="16px"><tspan font-size="16px" font-family="ShueiMGoStd" fill="#0B9ECE">&#43;</tspan></text>
<text kerning="auto" font-family="Kozuka Gothic Pr6N" stroke-width="1px" stroke="rgb(11, 158, 206)" fill-opacity="0" stroke-opacity="1" transform="matrix( 1.755, 0, 0, 1.75499988913536,3.42875500000002, 19.6791769833153)" font-size="16px"><tspan font-size="16px" font-family="ShueiMGoStd" fill="#0B9ECE">&#43;</tspan></text>
</svg>
                </div>
              </button>
              <div class="headerNavSub">
                <p class="headerNavSubItem">
                  <a class="headerNavSubLink" href="#">予防接種・ワクチン</a>
                </p>
                <p class="headerNavSubItem">
                  <a class="headerNavSubLink" href="#">健康診断</a>
                </p>
              </div>
              </button>
            </li>
          </ul>
          <ul class="headerNavList">
            <li class="headerNavItem">
              <a href="#">
                診療時間・アクセス
                <svg 
 xmlns="http://www.w3.org/2000/svg"
 xmlns:xlink="http://www.w3.org/1999/xlink"
 width="20px" height="20px" viewBox="0 0 20 20">
<path fill-rule="evenodd"  stroke-width="2px" stroke="rgb(11, 158, 206)" fill="rgb(11, 158, 206)"
 d="M15.182,10.014 L4.819,4.816 L4.819,15.212 L15.182,10.014 Z"/>
</svg>
              </a>
            </li>
            <li class="headerNavItem">
              <a href="#">
                ボランティア募集
                <svg 
 xmlns="http://www.w3.org/2000/svg"
 xmlns:xlink="http://www.w3.org/1999/xlink"
 width="20px" height="20px" viewBox="0 0 20 20">
<path fill-rule="evenodd"  stroke-width="2px" stroke="rgb(11, 158, 206)" fill="rgb(11, 158, 206)"
 d="M15.182,10.014 L4.819,4.816 L4.819,15.212 L15.182,10.014 Z"/>
</svg>
              </a>
            </li>
            <li class="headerNavItem">
              <a href="#">
                お知らせ
                <svg 
 xmlns="http://www.w3.org/2000/svg"
 xmlns:xlink="http://www.w3.org/1999/xlink"
 width="20px" height="20px" viewBox="0 0 20 20">
<path fill-rule="evenodd"  stroke-width="2px" stroke="rgb(11, 158, 206)" fill="rgb(11, 158, 206)"
 d="M15.182,10.014 L4.819,4.816 L4.819,15.212 L15.182,10.014 Z"/>
</svg>
              </a>
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
