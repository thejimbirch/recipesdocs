---
title: Default comments
recipe: comment_base
source: core/recipes/comment_base/recipe.yml
---

# Default comments

**Machine name:** `comment_base`  
**Source:** `core/recipes/comment_base/recipe.yml`

Allows commenting on content.
## Type

Comment type

## YAML definition

```yaml
name: 'Default comments'
description: 'Allows commenting on content.'
type: 'Comment type'
install:
  - comment
  - node
  - views
config:
  strict:
    # Treat field storages strictly, since they influence the database layout.
    - field.storage.comment.comment_body
    - field.storage.node.comment
  import:
    comment:
      - core.entity_view_mode.comment.full
      - field.storage.comment.comment_body
      - system.action.comment_delete_action
      - system.action.comment_publish_action
      - system.action.comment_save_action
      - system.action.comment_unpublish_action
      - views.view.comment
      - views.view.comments_recent
  actions:
    user.role.authenticated:
      grantPermissions:
        - 'access comments'
        - 'post comments'
        - 'skip comment approval'
    user.role.anonymous:
      grantPermission: 'access comments'
```
