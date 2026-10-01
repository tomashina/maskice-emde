#!/usr/bin/env bash

set -Eeuo pipefail

readonly EXPECTED_TARGET="/home/maskice2/public_html"
readonly BACKUP_BASE="/home/maskice2/deploy-backups/maskice-emde"

dry_run=0
if [[ "${1:-}" == "--dry-run" ]]; then
    dry_run=1
    shift
fi

target="${1:-$EXPECTED_TARGET}"

if [[ "$target" != "$EXPECTED_TARGET" ]]; then
    printf 'Refusing unexpected deployment target: %s\n' "$target" >&2
    exit 2
fi

if [[ ! -d "$target" ]]; then
    printf 'Deployment target does not exist: %s\n' "$target" >&2
    exit 2
fi

target="$(cd "$target" && pwd -P)"
expected_target="$(cd "$EXPECTED_TARGET" && pwd -P)"

if [[ "$target" != "$expected_target" ]]; then
    printf 'Deployment target resolves outside the expected document root.\n' >&2
    exit 2
fi

if [[ ! -f "$target/config.php" || ! -f "$target/admin/config.php" ]]; then
    printf 'OpenCart configuration sentinels are missing; deployment stopped.\n' >&2
    exit 2
fi

script_dir="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd -P)"
repo_root="$(cd "$script_dir/.." && pwd -P)"

if [[ "$(git -C "$repo_root" rev-parse --is-inside-work-tree 2>/dev/null)" != "true" ]]; then
    printf 'Deployment source is not a Git working tree.\n' >&2
    exit 2
fi

deploy_id="$(date -u +%Y%m%dT%H%M%SZ)-$$"
backup_root="$BACKUP_BASE/$deploy_id"
copied=0
unchanged=0
protected=0
backed_up=0

umask 027

is_protected_path() {
    case "$1" in
        .git|.git/*|.gitignore|.gitattributes|.cpanel.yml|README|README.*|docs|docs/*|tools|tools/*|extensions|extensions/*)
            return 0
            ;;
        config.php|admin/config.php|php.ini|.user.ini|.env|.env.*)
            return 0
            ;;
        storage|storage/*|image/catalog|image/catalog/*|image/cache|image/cache/*|sitemaps|sitemaps/*)
            return 0
            ;;
        system/storage/cache|system/storage/cache/*|system/storage/download|system/storage/download/*|system/storage/logs|system/storage/logs/*)
            return 0
            ;;
        system/storage/modification|system/storage/modification/*|system/storage/session|system/storage/session/*|system/storage/upload|system/storage/upload/*)
            return 0
            ;;
        *.sql|*.log|error_log|*.zip|*.tar|*.tar.gz|*.bak|*.old|*---)
            return 0
            ;;
    esac

    return 1
}

assert_safe_parent_path() {
    local relative_parent="$1"
    local cursor="$target"
    local part
    local old_ifs="$IFS"
    local -a parts=()

    IFS='/'
    read -r -a parts <<< "$relative_parent"
    IFS="$old_ifs"

    for part in "${parts[@]}"; do
        [[ -z "$part" || "$part" == "." ]] && continue
        cursor="$cursor/$part"

        if [[ -L "$cursor" ]]; then
            printf 'Refusing to traverse a symlink in the live tree: %s\n' "$cursor" >&2
            exit 3
        fi
    done
}

while IFS= read -r -d '' relative_path; do
    if is_protected_path "$relative_path"; then
        protected=$((protected + 1))
        continue
    fi

    case "$relative_path" in
        /*|..|../*|*/../*)
            printf 'Unsafe tracked path: %s\n' "$relative_path" >&2
            exit 3
            ;;
    esac

    source_path="$repo_root/$relative_path"
    destination_path="$target/$relative_path"
    destination_parent="${destination_path%/*}"
    relative_parent="${relative_path%/*}"

    if [[ "$relative_parent" == "$relative_path" ]]; then
        relative_parent="."
        destination_parent="$target"
    fi

    if [[ -L "$source_path" || ! -f "$source_path" ]]; then
        printf 'Only regular tracked files may be deployed: %s\n' "$relative_path" >&2
        exit 3
    fi

    assert_safe_parent_path "$relative_parent"

    if [[ -L "$destination_path" ]]; then
        printf 'Refusing to replace a live symlink: %s\n' "$destination_path" >&2
        exit 3
    fi

    if [[ -f "$destination_path" ]] && cmp -s -- "$source_path" "$destination_path"; then
        unchanged=$((unchanged + 1))
        continue
    fi

    if (( dry_run )); then
        copied=$((copied + 1))
        [[ -e "$destination_path" ]] && backed_up=$((backed_up + 1))
        continue
    fi

    mkdir -p -- "$destination_parent"

    if [[ -e "$destination_path" ]]; then
        backup_path="$backup_root/$relative_path"
        mkdir -p -- "${backup_path%/*}"
        cp -p -- "$destination_path" "$backup_path"
        backed_up=$((backed_up + 1))
    fi

    temporary_path="$destination_path.deploy-$deploy_id.tmp"
    cp -p -- "$source_path" "$temporary_path"
    mv -f -- "$temporary_path" "$destination_path"
    copied=$((copied + 1))
done < <(git -C "$repo_root" ls-files -z)

if (( dry_run )); then
    printf 'Dry run complete: %d file(s) would be copied, %d backed up, %d unchanged, %d protected.\n' \
        "$copied" "$backed_up" "$unchanged" "$protected"
else
    printf 'Deployment complete: %d file(s) copied, %d backed up, %d unchanged, %d protected.\n' \
        "$copied" "$backed_up" "$unchanged" "$protected"

    if (( backed_up > 0 )); then
        printf 'Backup: %s\n' "$backup_root"
    fi
fi
