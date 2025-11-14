---
title: Image media type
recipe: image_media_type
source: core/recipes/image_media_type/recipe.yml
---

# Image media type

**Machine name:** `image_media_type`  
**Source:** `core/recipes/image_media_type/recipe.yml`

Provides "Image" media type and related configuration. Use local images for reusable media.
## Type

Media type

## YAML definition

```yaml
name: 'Image media type'
description: 'Provides "Image" media type and related configuration. Use local images for reusable media.'
type: 'Media type'
install:
  - media_library
  - path
  - views
config:
  strict:
    # Treat field storages strictly, since they influence the database layout.
    - field.storage.media.field_media_image
  import:
    file:
      - views.view.files
    media_library:
      - core.entity_view_mode.media.media_library
      - core.entity_form_mode.media.media_library
      - image.style.media_library
      - views.view.media_library
    media:
      - core.entity_view_mode.media.full
      - system.action.media_delete_action
      - system.action.media_publish_action
      - system.action.media_save_action
      - system.action.media_unpublish_action
      - views.view.media
    image:
      - image.style.medium
      - image.style.large
      - image.style.thumbnail
```
