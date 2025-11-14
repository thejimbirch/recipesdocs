---
title: Basic page
recipe: page_content_type
source: core/recipes/page_content_type/recipe.yml
---

# Basic page

**Machine name:** `page_content_type`  
**Source:** `core/recipes/page_content_type/recipe.yml`

Provides Basic page content type and related configuration. Use <em>basic pages</em> for your static content, such as an 'About us' page.
## Type

Content type

## YAML definition

```yaml
name: 'Basic page'
description: "Provides Basic page content type and related configuration. Use <em>basic pages</em> for your static content, such as an 'About us' page."
type: 'Content type'
install:
  - node
  - path
config:
  import:
    node:
      - core.entity_view_mode.node.full
      - core.entity_view_mode.node.rss
      - core.entity_view_mode.node.teaser
      - system.action.node_delete_action
      - system.action.node_make_sticky_action
      - system.action.node_make_unsticky_action
      - system.action.node_promote_action
      - system.action.node_publish_action
      - system.action.node_save_action
      - system.action.node_unpromote_action
      - system.action.node_unpublish_action
```
