#!/usr/bin/env bash
set -euo pipefail

# Portfolio (Laravel / MySQL) — Database Backup to Telegram
# Reads all DB & Telegram settings strictly from .env (no hardcoded secrets).
# Usage:
#   ./deploy/db_backup_telegram.sh           # Daily backup (7 days local retention)
#   ./deploy/db_backup_telegram.sh --monthly # Monthly backup (90 days local retention)

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_DIR="$(cd "${SCRIPT_DIR}/.." && pwd)"
ENV_FILE="${PROJECT_DIR}/.env"

if [[ ! -f "$ENV_FILE" ]]; then
  echo "[ERROR] Missing ${ENV_FILE}" >&2
  exit 1
fi

get_env() {
  local key="$1"
  local line
  line=$(grep -E "^${key}=" "$ENV_FILE" | tail -n 1 || true)
  local val="${line#*=}"
  val="${val%$'\r'}"
  val="${val#\"}"
  val="${val%\"}"
  val="${val#\'}"
  val="${val%\'}"
  printf '%s' "$val"
}

DB_HOST="$(get_env DB_HOST)"
DB_PORT="$(get_env DB_PORT)"
DB_NAME="$(get_env DB_DATABASE)"
DB_USER="$(get_env DB_USERNAME)"
DB_PASS="$(get_env DB_PASSWORD)"
BOT_TOKEN="$(get_env BACKUP_TG_BOT_TOKEN)"
CHAT_ID="$(get_env BACKUP_TG_CHAT_ID)"
TOPIC_ID="$(get_env BACKUP_TG_TOPIC_ID)"
RETENTION_DAYS="$(get_env BACKUP_RETENTION_DAYS)"

DB_HOST="${DB_HOST:-127.0.0.1}"
DB_PORT="${DB_PORT:-3306}"
RETENTION_DAYS="${RETENTION_DAYS:-7}"
BACKUP_DIR="/opt/backups/portfolio"
MODE="DAILY"

if [[ "${1:-}" == "--monthly" ]]; then
  MODE="MONTHLY"
  RETENTION_DAYS="90"
fi

if [[ -z "$DB_NAME" || -z "$DB_USER" || -z "$BOT_TOKEN" || -z "$CHAT_ID" ]]; then
  echo "[ERROR] DB_DATABASE, DB_USERNAME, BACKUP_TG_BOT_TOKEN, and BACKUP_TG_CHAT_ID must be set in ${ENV_FILE}" >&2
  exit 1
fi

mkdir -p "$BACKUP_DIR"
chmod 700 "$BACKUP_DIR"

DATE="$(date +"%Y-%m-%d_%H-%M-%S")"
if [[ "$MODE" == "MONTHLY" ]]; then
  STAMP="$(date +"%Y-%m-%B")"
  FILE_NAME="PORTFOLIO_MONTHLY_${STAMP}.sql.gz"
else
  FILE_NAME="PORTFOLIO_BACKUP_${DATE}.sql.gz"
fi
FILE_PATH="${BACKUP_DIR}/${FILE_NAME}"
HOST_NAME="$(hostname)"

send_tg_alert() {
  local msg="$1"
  local args=(-s -X POST "https://api.telegram.org/bot${BOT_TOKEN}/sendMessage" -F "chat_id=${CHAT_ID}" -F "text=${msg}")
  [[ -n "$TOPIC_ID" ]] && args+=(-F "message_thread_id=${TOPIC_ID}")
  curl "${args[@]}" >/dev/null || true
}

echo "[INFO] Starting Portfolio (${MODE}) MySQL backup..."
if ! MYSQL_PWD="$DB_PASS" mysqldump --single-transaction --no-tablespaces -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USER" "$DB_NAME" | gzip > "$FILE_PATH"; then
  rm -f "$FILE_PATH"
  send_tg_alert "❌ Portfolio ${MODE} Backup FAILED (mysqldump error) on ${HOST_NAME} at ${DATE}"
  exit 1
fi

FILE_SIZE_BYTES=$(stat -c%s "$FILE_PATH")
FILE_SIZE_HUMAN=$(du -h "$FILE_PATH" | cut -f1)

if (( FILE_SIZE_BYTES > 50 * 1024 * 1024 )); then
  send_tg_alert "⚠️ Portfolio ${MODE} Backup saved locally (${FILE_SIZE_HUMAN}) but exceeds Telegram 50MB limit."
  echo "[WARN] Backup exceeds 50MB Telegram limit: ${FILE_PATH}" >&2
  exit 0
fi

CAPTION="✅ Portfolio (${MODE}) Database Backup
📅 Date: ${DATE}
💾 Size: ${FILE_SIZE_HUMAN}
🗄 Database: ${DB_NAME} (MySQL)
🖥 Server: ${HOST_NAME}"

CURL_ARGS=(
  -s -X POST "https://api.telegram.org/bot${BOT_TOKEN}/sendDocument"
  -F "chat_id=${CHAT_ID}"
  -F "document=@${FILE_PATH}"
  -F "caption=${CAPTION}"
)
[[ -n "$TOPIC_ID" ]] && CURL_ARGS+=(-F "message_thread_id=${TOPIC_ID}")

RESPONSE=$(curl "${CURL_ARGS[@]}")
if [[ "$RESPONSE" == *'"ok":true'* ]]; then
  echo "[OK] Sent ${FILE_NAME} (${FILE_SIZE_HUMAN}) to Telegram!"
else
  echo "[ERROR] Telegram upload failed: ${RESPONSE}" >&2
  exit 1
fi

if [[ "$MODE" == "MONTHLY" ]]; then
  find "$BACKUP_DIR" -type f -name "PORTFOLIO_MONTHLY_*.sql.gz" -mtime +"$RETENTION_DAYS" -delete
else
  find "$BACKUP_DIR" -type f -name "PORTFOLIO_BACKUP_*.sql.gz" -mtime +"$RETENTION_DAYS" -delete
fi
echo "[OK] Retention cleanup done (${RETENTION_DAYS} days)."
