---
title: Standard Responsive Images
recipe: standard_responsive_images
source: core/recipes/standard_responsive_images/recipe.yml
---

# Standard Responsive Images

**Machine name:** `standard_responsive_images`  
**Source:** `core/recipes/standard_responsive_images/recipe.yml`

Provides basic responsive images and accompanying image styles.
## Type

Responsive image

## YAML definition

```yaml
name: 'Standard Responsive Images'
description: 'Provides basic responsive images and accompanying image styles.'
type: 'Responsive image'
install:
  - responsive_image
config:
  # There's no need to conflict with existing responsive image styles.
  strict: false
  import:
    image: '*'
```
