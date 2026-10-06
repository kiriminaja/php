# KiriminAja PHP SDK — Release Tooling
# Usage:
#   make release          — bump patch, commit, tag, and push
#   make release-minor    — bump minor, commit, tag, and push
#   make release-major    — bump major, commit, tag, and push
#   make changelog        — regenerate CHANGELOG.md without releasing
#   make test             — run tests in parallel with ParaTest

SHELL := /bin/bash
.PHONY: test changelog release release-minor release-major _release

REPO_URL := https://github.com/kiriminaja/php
COMPOSER := composer.json
COMPOSER_BIN ?= composer
REMOTE ?= origin

# ---------------------------------------------------------------------------
# Helpers
# ---------------------------------------------------------------------------

# Current version from composer.json
CURRENT_VERSION = $(shell php -r "echo json_decode(file_get_contents('$(COMPOSER)'))->version;")

# Bump functions — pure Make
_bump_patch = $(shell echo $(CURRENT_VERSION) | awk -F. '{printf "%s.%s.%s", $$1, $$2, $$3+1}')
_bump_minor = $(shell echo $(CURRENT_VERSION) | awk -F. '{printf "%s.%s.0", $$1, $$2+1}')
_bump_major = $(shell echo $(CURRENT_VERSION) | awk -F. '{printf "%s.0.0", $$1+1}')

# ---------------------------------------------------------------------------
# Commands
# ---------------------------------------------------------------------------

test:
	vendor/bin/paratest --configuration=phpunit.xml

changelog:
	@echo "📝 Generating CHANGELOG.md …"
	@php changelog.php
	@echo "✅ CHANGELOG.md updated"

release:
	$(MAKE) _release NEW_VERSION=$(_bump_patch)

release-minor:
	$(MAKE) _release NEW_VERSION=$(_bump_minor)

release-major:
	$(MAKE) _release NEW_VERSION=$(_bump_major)

_release:
ifndef NEW_VERSION
	$(error NEW_VERSION is not set)
endif
	@set -euo pipefail; \
	if [[ -n "$$(git status --porcelain)" ]]; then \
		echo "Commit or stash all changes before releasing." >&2; exit 1; \
	fi; \
	branch=$$(git symbolic-ref --quiet --short HEAD) || { echo "Cannot release from detached HEAD." >&2; exit 1; }; \
	[[ "$(NEW_VERSION)" =~ ^[0-9]+\.[0-9]+\.[0-9]+$$ ]] || { echo "Invalid release version: $(NEW_VERSION)" >&2; exit 1; }; \
	php -r 'exit(version_compare($$argv[1], $$argv[2], ">") ? 0 : 1);' "$(NEW_VERSION)" "$(CURRENT_VERSION)" || { echo "Release version must exceed $(CURRENT_VERSION)." >&2; exit 1; }; \
	if git show-ref --verify --quiet "refs/tags/$(NEW_VERSION)"; then \
		echo "Tag $(NEW_VERSION) already exists locally." >&2; exit 1; \
	fi; \
	remote_tag=$$(git ls-remote --tags "$(REMOTE)" "refs/tags/$(NEW_VERSION)"); \
	if [[ -n "$$remote_tag" ]]; then echo "Tag $(NEW_VERSION) already exists on $(REMOTE)." >&2; exit 1; fi; \
	$(COMPOSER_BIN) validate; \
	$(MAKE) test; \
	echo "🚀 Releasing $(CURRENT_VERSION) → $(NEW_VERSION)"; \
	php -r " \
		\$$f = '$(COMPOSER)'; \
		\$$j = json_decode(file_get_contents(\$$f), true); \
		\$$j['version'] = '$(NEW_VERSION)'; \
		file_put_contents(\$$f, json_encode(\$$j, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . \"\n\"); \
	"; \
	$(COMPOSER_BIN) update --lock --no-install --no-interaction --no-progress; \
	$(COMPOSER_BIN) validate; \
	php changelog.php; \
	git add -- $(COMPOSER) composer.lock CHANGELOG.md; \
	git commit -m "chore(release): v$(NEW_VERSION)"; \
	git tag -a "$(NEW_VERSION)" -m "v$(NEW_VERSION)"; \
	git push --atomic "$(REMOTE)" "HEAD:refs/heads/$$branch" "refs/tags/$(NEW_VERSION)"; \
	echo "🎉 Released v$(NEW_VERSION) on $$branch (commit and tag pushed to $(REMOTE))"; \
	echo "   GitHub Actions will test the tag and publish $(REPO_URL)/releases/tag/$(NEW_VERSION)"
