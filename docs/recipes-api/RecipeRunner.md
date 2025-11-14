---
title: Drupal\Core\Recipe\RecipeRunner
source: core/lib/Drupal/Core/Recipe/RecipeRunner.php
---

# Drupal\Core\Recipe\RecipeRunner

**Source:** `core/lib/Drupal/Core/Recipe/RecipeRunner.php`

Applies a recipe.

## Notes

This class is currently static and use \Drupal::service() in order to put off
having to solve issues caused by container rebuilds during module install and
configuration import.

  This API is experimental.

  inject and re-inject services.

## Annotations

- `@internal`
- `@todo https://www.drupal.org/i/3439717 Determine if there is a better to`

