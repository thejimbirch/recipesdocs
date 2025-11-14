---
title: Drupal\Core\DefaultContent\PreExportEvent
source: core/lib/Drupal/Core/DefaultContent/PreExportEvent.php
---

# Drupal\Core\DefaultContent\PreExportEvent

**Source:** `core/lib/Drupal/Core/DefaultContent/PreExportEvent.php`

Event dispatched before an entity is exported as default content.

## Notes

Subscribers to this event can attach callback functions which can be used
to export specific fields or field types. When exporting fields that either
have that name, or match that data type, callback will be called for each
field item with two arguments: the field item, and an object which holds
metadata (e.g., dependencies) about the entity being exported. The callback
should return an array of exported values for that field item, or NULL if the
item should not be exported.

Subscribers may also mark specific fields as either not exportable, or
as explicitly exportable -- for example, computed fields are not normally
exported, but a subscriber could flag a computed field as exportable if
circumstances require it.

