---
title: Drupal\Core\Recipe\InputCollectorInterface
source: core/lib/Drupal/Core/Recipe/InputCollectorInterface.php
---

# Drupal\Core\Recipe\InputCollectorInterface

**Source:** `core/lib/Drupal/Core/Recipe/InputCollectorInterface.php`

Collects user-provided input values for recipes.

## Notes

Implementations of this interface are responsible for obtaining values
required by recipes at runtime. This allows recipes to request dynamic
information (for example, a site name or administrator email address) from
the user or another source, rather than hardcoding values.

## Annotations

- `@see \Drupal\Core\Recipe\FormInputCollector`
- `@see \Drupal\Core\Recipe\PredefinedInputCollector`

