---
title: User pictures
recipe: user_picture
source: core/recipes/user_picture/recipe.yml
---

# User pictures

**Machine name:** `user_picture`  
**Source:** `core/recipes/user_picture/recipe.yml`

Adds the ability for user accounts to have pictures (avatars).
## Type

Users

## YAML definition

```yaml
name: User pictures
description: 'Adds the ability for user accounts to have pictures (avatars).'
type: Users
install:
  - image
  - user
config:
  strict:
    # Treat field storages strictly, since they influence the database layout.
    - field.storage.user.user_picture
  import:
    image:
      - image.style.thumbnail
```
