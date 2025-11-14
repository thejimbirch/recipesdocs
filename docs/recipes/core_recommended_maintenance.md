---
title: Recommended Maintenance
recipe: core_recommended_maintenance
source: core/recipes/core_recommended_maintenance/recipe.yml
---

# Recommended Maintenance

**Machine name:** `core_recommended_maintenance`  
**Source:** `core/recipes/core_recommended_maintenance/recipe.yml`

Sets up modules recommended for site maintenance.
## Type

Maintenance

## YAML definition

```yaml
name: 'Recommended Maintenance'
description: 'Sets up modules recommended for site maintenance.'
type: 'Maintenance'
install:
  - automated_cron
  - announcements_feed
  - dblog
  - views
config:
  # Leave existing config as-is.
  strict: false
  import:
    automated_cron:
      - automated_cron.settings
    dblog:
      - views.view.watchdog
    system:
      - system.cron
```
