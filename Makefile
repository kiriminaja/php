# KiriminAja PHP SDK — Release Tooling
# Usage:
#   make release          — bump patch (1.3.3 → 1.3.4)
#   make release-minor    — bump minor (1.3.3 → 1.4.0)
#   make release-major    — bump major (1.3.3 → 2.0.0)
#   make changelog        — regenerate CHANGELOG.md without releasing
#   make test             — run tests

SHELL := /bin/bash
.PHONY: test changelog release release-minor release-major _release

REPO_URL := https://github.com/kiriminaja/php
COMPOSER := composer.json

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
	vendor/bin/phpunit tests

changelog:
	@echo "📝 Generating CHANGELOG.md …"
	@php changelog.php
	@echo "✅ CHANGELOG.md updated"

release: test
	$(MAKE) _release NEW_VERSION=$(_bump_patch)

release-minor: test
	$(MAKE) _release NEW_VERSION=$(_bump_minor)

release-major: test
	$(MAKE) _release NEW_VERSION=$(_bump_major)

_release:
ifndef NEW_VERSION
	$(error NEW_VERSION is not set)
endif
	@echo ""
	@echo "🚀 Releasing $(CURRENT_VERSION) → $(NEW_VERSION)"
	@echo ""

	@# 1. Update version in composer.json
	@php -r " \
		\$$f = '$(COMPOSER)'; \
		\$$j = json_decode(file_get_contents(\$$f), true); \
		\$$j['version'] = '$(NEW_VERSION)'; \
		file_put_contents(\$$f, json_encode(\$$j, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . \"\n\"); \
	"
	@echo "   ✔ composer.json → $(NEW_VERSION)"

	@# 2. Generate changelog
	@php changelog.php
	@echo "   ✔ CHANGELOG.md updated"

	@# 3. Commit, tag, push
	@git add $(COMPOSER) CHANGELOG.md
	@git commit -m "chore(release): v$(NEW_VERSION)"
	@git tag "$(NEW_VERSION)" -m "v$(NEW_VERSION)"
	@git push origin HEAD --follow-tags
	@echo ""
	@echo "   ✔ Pushed tag $(NEW_VERSION)"
	@echo ""
	@echo "🎉 Released v$(NEW_VERSION)"
	@echo "   $(REPO_URL)/releases/new?tag=$(NEW_VERSION)&title=v$(NEW_VERSION)"
