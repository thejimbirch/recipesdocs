---
title: Document media type
recipe: document_media_type
source: core/recipes/document_media_type/recipe.yml
---

# Document media type

**Machine name:** `document_media_type`  
**Source:** `core/recipes/document_media_type/recipe.yml`

Provides "Document" media type and related configuration to enable uploaded files or documents, such as a PDF.
## Type

Media type

## YAML definition

```yaml
name: 'Document media type'
description: 'Provides "Document" media type and related configuration to enable uploaded files or documents, such as a PDF.'
type: 'Media type'
install:
  - media_library
  - path
  - views
config:
  strict:
    # Treat field storages strictly, since they influence the database layout.
    - field.storage.media.field_media_document
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
      - image.style.thumbnail
```
