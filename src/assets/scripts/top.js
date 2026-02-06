import Swiper from 'swiper'
import { Autoplay } from 'swiper/modules'
import 'swiper/css'

function initVisualSwiper() {
  const el = document.querySelector('.js-visual-swiper')
  if (!el) return

  // 二重初期化防止（Swiperが付与するclass）
  if (el.classList.contains('swiper-initialized')) return

  const prefersReducedMotion =
    window.matchMedia?.('(prefers-reduced-motion: reduce)')?.matches ?? false

  new Swiper(el, {
    modules: [Autoplay],
    centeredSlides: true,
    slidesPerView: 'auto',
    spaceBetween: 10,
    loop: true,
    speed: 800,
    grabCursor: true,
    autoplay: prefersReducedMotion
      ? false
      : {
          delay: 5000,
          disableOnInteraction: false,
          pauseOnMouseEnter: true,
        },
    breakpoints: {
      // md (768px) 以上
      768: {
        spaceBetween: 85,
      },
    },
  })
}

function initTopPage() {
  initVisualSwiper()
}

// DOMContentLoaded時に初期化
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initTopPage)
} else {
  initTopPage()
}
