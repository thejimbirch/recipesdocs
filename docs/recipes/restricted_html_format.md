---
title: Restricted HTML
recipe: restricted_html_format
source: core/recipes/restricted_html_format/recipe.yml
---

# Restricted HTML

**Machine name:** `restricted_html_format`  
**Source:** `core/recipes/restricted_html_format/recipe.yml`

Provides "Restricted HTML" text format.
## Type

Text format

## YAML definition

```yaml
name: 'Restricted HTML'
description: 'Provides "Restricted HTML" text format.'
type: 'Text format'
install:
  - filter
config:
  # If the restricted_html format already exists, leave it as-is.
  strict: false
  import:
    filter: '*'
  actions:
    user.role.anonymous:
      grantPermission: 'use text format restricted_html'
```
