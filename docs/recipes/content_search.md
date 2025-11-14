---
title: Content search
recipe: content_search
source: core/recipes/content_search/recipe.yml
---

# Content search

**Machine name:** `content_search`  
**Source:** `core/recipes/content_search/recipe.yml`

Adds a page that can search site content.
## Type

Search

## YAML definition

```yaml
name: 'Content search'
type: Search
description: 'Adds a page that can search site content.'
install:
  - node
  - search
config:
  import:
    node:
      - core.entity_view_mode.node.search_index
      - core.entity_view_mode.node.search_result
      - search.page.node_search
  actions:
    user.role.anonymous:
      grantPermission: 'search content'
    user.role.authenticated:
      grantPermission: 'search content'
```
