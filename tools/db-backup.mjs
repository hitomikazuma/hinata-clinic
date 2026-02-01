#!/usr/bin/env node
import fs from 'node:fs'
import path from 'node:path'
import { execSync } from 'node:child_process'

const projectRoot = process.cwd()
const outDir = path.resolve(projectRoot, 'sql')

const pad2 = (n) => String(n).padStart(2, '0')
const buildTimestamp = () => {
  const d = new Date()
  const yyyy = d.getFullYear()
  const mm = pad2(d.getMonth() + 1)
  const dd = pad2(d.getDate())
  const HH = pad2(d.getHours())
  const MM = pad2(d.getMinutes())
  const SS = pad2(d.getSeconds())
  return `${yyyy}${mm}${dd}-${HH}${MM}${SS}`
}

const ensureDir = (dir) => {
  if (!fs.existsSync(dir)) fs.mkdirSync(dir, { recursive: true })
}

const main = () => {
  ensureDir(outDir)
  const ts = buildTimestamp()
  const relPath = `./sql/backup-${ts}.sql`
  const cmd = `wp-env run cli wp db export ${relPath}`
  try {
    execSync(cmd, { stdio: 'inherit' })
  } catch (err) {
    process.exit(err.status || 1)
  }
}

main()
