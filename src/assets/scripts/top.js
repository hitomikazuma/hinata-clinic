function initTopPage() {}

// DOMContentLoaded時に初期化
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initTopPage)
} else {
  initTopPage()
}
