import js from '@eslint/js'
import globals from 'globals'
import prettier from 'eslint-config-prettier'

export default [
  // グローバル ignores
  {
    ignores: ['node_modules/**', 'dist/**'],
  },

  // 推奨設定
  js.configs.recommended,

  // プロジェクト設定
  {
    files: ['**/*.js'],
    languageOptions: {
      ecmaVersion: 'latest',
      sourceType: 'module',
      globals: {
        ...globals.browser,
      },
    },
    rules: {
      // 'no-console': 'warn',
    },
  },

  // Prettier との競合を無効化（最後に配置）
  prettier,
]
