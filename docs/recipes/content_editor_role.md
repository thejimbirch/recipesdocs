---
title: Content editor role
recipe: content_editor_role
source: core/recipes/content_editor_role/recipe.yml
---

# Content editor role

**Machine name:** `content_editor_role`  
**Source:** `core/recipes/content_editor_role/recipe.yml`

Provides the Content editor role.
## Type

User role

## YAML definition

```yaml
name: 'Content editor role'
description: 'Provides the Content editor role.'
type: 'User role'
install:
  # Node provides the `view own unpublished content` permission.
  - node
config:
  # If the content_editor role already exists, we don't really care what it looks like.
  strict: false
  actions:
    user.role.content_editor:
      grantPermissions:
        - 'access administration pages'
        - 'view own unpublished content'
```
