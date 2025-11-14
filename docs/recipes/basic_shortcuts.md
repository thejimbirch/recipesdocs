---
title: Basic shortcuts
recipe: basic_shortcuts
source: core/recipes/basic_shortcuts/recipe.yml
---

# Basic shortcuts

**Machine name:** `basic_shortcuts`  
**Source:** `core/recipes/basic_shortcuts/recipe.yml`

Provides a basic set of shortcuts for logged-in users.
## Type

Administration

## YAML definition

```yaml
name: 'Basic shortcuts'
description: 'Provides a basic set of shortcuts for logged-in users.'
type: Administration
install:
  - shortcut
config:
  import:
    shortcut:
      - shortcut.set.default
  actions:
    user.role.authenticated:
      grantPermission: 'access shortcuts'
```
