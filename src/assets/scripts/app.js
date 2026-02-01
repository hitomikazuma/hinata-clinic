import '../stylesheets/app.scss'

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
