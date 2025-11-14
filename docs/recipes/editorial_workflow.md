---
title: Editorial workflow
recipe: editorial_workflow
source: core/recipes/editorial_workflow/recipe.yml
---

# Editorial workflow

**Machine name:** `editorial_workflow`  
**Source:** `core/recipes/editorial_workflow/recipe.yml`

Provides an editorial workflow for moderating content.
## Type

Workflow

## YAML definition

```yaml
name: 'Editorial workflow'
description: 'Provides an editorial workflow for moderating content.'
type: 'Workflow'
install:
  - content_moderation
  # The moderated_content view depends on Node.
  - node
  - views
config:
  # If the config we're shipping already exists, we don't really care what
  # it looks like.
  strict: false
  import:
    content_moderation:
      - views.view.moderated_content
```
