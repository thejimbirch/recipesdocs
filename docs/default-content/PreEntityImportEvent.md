---
title: Drupal\Core\DefaultContent\PreEntityImportEvent
source: core/lib/Drupal/Core/DefaultContent/PreEntityImportEvent.php
---

# Drupal\Core\DefaultContent\PreEntityImportEvent

**Source:** `core/lib/Drupal/Core/DefaultContent/PreEntityImportEvent.php`

Event dispatched before an entity is created during default content import.

## Notes

This event is dispatched for each entity before it is created from the
decoded data. Subscribers can modify the entity data (default and
translations) but not the metadata.

