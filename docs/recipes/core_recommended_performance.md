---
title: Recommended Performance
recipe: core_recommended_performance
source: core/recipes/core_recommended_performance/recipe.yml
---

# Recommended Performance

**Machine name:** `core_recommended_performance`  
**Source:** `core/recipes/core_recommended_performance/recipe.yml`

Sets up modules for improved site performance.
## Type

Performance

## YAML definition

```yaml
name: 'Recommended Performance'
description: 'Sets up modules for improved site performance.'
type: 'Performance'
install:
  - page_cache
  - dynamic_page_cache
  - big_pipe
```
