---
title: Drupal\Core\Config\Action\Plugin\ConfigAction\CreateForEachBundle
source: core/lib/Drupal/Core/Config/Action/Plugin/ConfigAction/CreateForEachBundle.php
---

# Drupal\Core\Config\Action\Plugin\ConfigAction\CreateForEachBundle

**Source:** `core/lib/Drupal/Core/Config/Action/Plugin/ConfigAction/CreateForEachBundle.php`

Creates config entities for each bundle of a particular entity type.

## Notes

An example of using this in a recipe's config actions would be:
node.type.*:
  createForEach:
    language.content_settings.node.%bundle:
      target_entity_type_id: node
      target_bundle: %bundle
    image.style.node_%bundle_big:
      label: 'Big images for %label content'
This will create two entities for each existing content type: a content
language settings entity, and an image style. For example, for a content type
called `blog`, this will create `language.content_settings.node.blog` and
`image.style.node_blog_big`, with the given values. The `%bundle` and
`%label` placeholders will be replaced with the ID and label of the content
type, respectively.

  This API is experimental.

## Annotations

- `@code`
- `@endcode`
- `@internal`

