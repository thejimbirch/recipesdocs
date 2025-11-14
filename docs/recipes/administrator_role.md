---
title: Administrator role
recipe: administrator_role
source: core/recipes/administrator_role/recipe.yml
---

# Administrator role

**Machine name:** `administrator_role`  
**Source:** `core/recipes/administrator_role/recipe.yml`

Provides the Administrator role.
## Type

User role

## YAML definition

```yaml
name: 'Administrator role'
description: 'Provides the Administrator role.'
type: 'User role'
config:
  # If the administrator role already exists, we don't really care what it looks like.
  strict: false
```
