---
title: Drupal\Core\DefaultContent\PreImportEvent
source: core/lib/Drupal/Core/DefaultContent/PreImportEvent.php
---

# Drupal\Core\DefaultContent\PreImportEvent

**Source:** `core/lib/Drupal/Core/DefaultContent/PreImportEvent.php`

Event dispatched before default content is imported.

## Notes

Subscribers to this event should avoid modifying content, because it is
probably about to change again. This event is best used for tasks like
notifications, logging, or updating a value in state. It can also be used
to skip importing certain entities, identified by their UUID.

