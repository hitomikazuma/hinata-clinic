import '../stylesheets/app.scss'

// スライドダウン（上から下へ開く）
function slideDown(el, duration = 300) {
  el.style.display = 'block'
  const cs = getComputedStyle(el)
  const pt = parseFloat(cs.paddingTop) || 0
  const pb = parseFloat(cs.paddingBottom) || 0
  const mb = parseFloat(cs.marginBottom) || 0
  const height = el.scrollHeight // padding含む自然な高さ
  el.style.overflow = 'hidden'
  el.style.height = '0px'
  el.style.paddingTop = '0px'
  el.style.paddingBottom = '0px'
  el.style.marginBottom = '0px'
  el.offsetHeight // reflow
  const t = `all ${duration}ms ease`
  el.style.transition = t
  el.style.height = `${height}px`
  el.style.paddingTop = `${pt}px`
  el.style.paddingBottom = `${pb}px`
  el.style.marginBottom = `${mb}px`
  const onEnd = () => {
    el.style.removeProperty('height')
    el.style.removeProperty('padding-top')
    el.style.removeProperty('padding-bottom')
    el.style.removeProperty('margin-bottom')
    el.style.removeProperty('overflow')
    el.style.removeProperty('transition')
    el.removeEventListener('transitionend', onEnd)
  }
  el.addEventListener('transitionend', onEnd, { once: true })
}

// スライドアップ（下から上へ閉じる）
function slideUp(el, duration = 300) {
  el.style.overflow = 'hidden'
  el.style.height = `${el.scrollHeight}px`
  el.offsetHeight // reflow
  const t = `all ${duration}ms ease`
  el.style.transition = t
  el.style.height = '0px'
  el.style.paddingTop = '0px'
  el.style.paddingBottom = '0px'
  el.style.marginBottom = '0px'
  const onEnd = () => {
    el.style.display = 'none'
    el.style.removeProperty('height')
    el.style.removeProperty('padding-top')
    el.style.removeProperty('padding-bottom')
    el.style.removeProperty('margin-bottom')
    el.style.removeProperty('overflow')
    el.style.removeProperty('transition')
    el.removeEventListener('transitionend', onEnd)
  }
  el.addEventListener('transitionend', onEnd, { once: true })
}

document.addEventListener('DOMContentLoaded', () => {
  // ハンバーガーメニュー開閉
  const header = document.querySelector('.header')
  const menuBtn = document.querySelector('.headerMenuButton')
  const infoArea = document.querySelector('.headerInfoArea')

  if (menuBtn && header) {
    const menuBtnText = menuBtn.querySelector('.headerMenuButtonText')
    menuBtn.addEventListener('click', () => {
      header.classList.toggle('isMenuOpen')
      if (menuBtnText) {
        menuBtnText.textContent = header.classList.contains('isMenuOpen') ? 'Close' : 'Menu'
      }
    })
  }

  // ヘッダーナビ：アコーディオン開閉（headerNavButton → headerNavSub）
  const buttons = document.querySelectorAll('.headerNavButton')
  if (!buttons.length) return

  buttons.forEach((btn) => {
    btn.addEventListener('click', () => {
      const item = btn.closest('.headerNavItem')
      if (!item) return
      const sub = item.querySelector('.headerNavSub')
      if (!sub) return
      const isOpen = item.classList.contains('isOpen')

      // 他の開いている項目を閉じる
      document.querySelectorAll('.headerNavItem.isOpen').forEach((openItem) => {
        if (openItem !== item) {
          openItem.classList.remove('isOpen')
          const openSub = openItem.querySelector('.headerNavSub')
          if (openSub) slideUp(openSub)
        }
      })

      if (isOpen) {
        item.classList.remove('isOpen')
        slideUp(sub)
      } else {
        item.classList.add('isOpen')
        slideDown(sub)
      }
    })
  })
})

// トップページ判定してtop.jsを読み込む
function isTopPage() {
  // bodyクラスで判定（WordPressの標準クラス）
  if (document.body.classList.contains('home')) {
    return true
  }
  // URLで判定（フロントページの場合）
  const path = window.location.pathname
  if (path === '/' || path === '/index.php') {
    return true
  }
  return false
}

// トップページの場合のみtop.jsを読み込む
if (isTopPage()) {
  import('./top.js').then((module) => {
    // top.jsは自動実行されるので、特に何もしない
  })
}
