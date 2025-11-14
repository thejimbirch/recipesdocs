---
title: Full HTML editor
recipe: full_html_format_editor
source: core/recipes/full_html_format_editor/recipe.yml
---

# Full HTML editor

**Machine name:** `full_html_format_editor`  
**Source:** `core/recipes/full_html_format_editor/recipe.yml`

Provides "Full HTML" text format along with WYSIWYG editor and related configuration.
## Type

Text format editor

## YAML definition

```yaml
name: 'Full HTML editor'
description: 'Provides "Full HTML" text format along with WYSIWYG editor and related configuration.'
type: 'Text format editor'
install:
  - ckeditor5
config:
  # If the full_html format and editor already exist, leave them as-is.
  strict: false
```
