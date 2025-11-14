---
title: Drupal\Core\Recipe\RecipeAppliedEvent
source: core/lib/Drupal/Core/Recipe/RecipeAppliedEvent.php
---

# Drupal\Core\Recipe\RecipeAppliedEvent

**Source:** `core/lib/Drupal/Core/Recipe/RecipeAppliedEvent.php`

Event dispatched after a recipe has been applied.

## Notes

Subscribers to this event should avoid modifying config or content, because
it is very likely that the recipe was applied as part of a chain of recipes,
so config and content are probably about to change again. This event is best
used for tasks like notifications, logging or updating a value in state.

