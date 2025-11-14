---
title: Tags
recipe: tags_taxonomy
source: core/recipes/tags_taxonomy/recipe.yml
---

# Tags

**Machine name:** `tags_taxonomy`  
**Source:** `core/recipes/tags_taxonomy/recipe.yml`

Provides "Tags" taxonomy vocabulary and related configuration. Use tags to group content on similar topics into categories.
## Type

Taxonomy

## YAML definition

```yaml
name: Tags
description: 'Provides "Tags" taxonomy vocabulary and related configuration. Use tags to group content on similar topics into categories.'
type: 'Taxonomy'
install:
  - taxonomy
  # Added until the following issue is fixed.
  # Taxonomy should provide a fallback way to display terms when Views is not enabled.
  # https://www.drupal.org/project/drupal/issues/3479980
  - views
config:
  # If the `tags` vocabulary already exists, there's no need to conflict with it.
  strict: false
  import:
    taxonomy: '*'
```
