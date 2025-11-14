---
title: Basic HTML editor
recipe: basic_html_format_editor
source: core/recipes/basic_html_format_editor/recipe.yml
---

# Basic HTML editor

**Machine name:** `basic_html_format_editor`  
**Source:** `core/recipes/basic_html_format_editor/recipe.yml`

Provides "Basic HTML" text format along with WYSIWYG editor and related configuration.
## Type

Text format editor

## YAML definition

```yaml
name: 'Basic HTML editor'
description: 'Provides "Basic HTML" text format along with WYSIWYG editor and related configuration.'
type: 'Text format editor'
install:
  - ckeditor5
config:
  # If the basic_html format and editor already exist, leave them as-is.
  strict: false
  actions:
    user.role.authenticated:
      grantPermission: 'use text format basic_html'
```
