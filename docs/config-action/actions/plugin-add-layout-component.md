---
title: add_layout_component
type: config-action-plugin
source: core/modules/layout_builder/src/Plugin/ConfigAction/AddComponent.php
---

# add_layout_component

**Type:** Config action plugin (`ConfigAction` attribute)  
**Plugin ID:** `add_layout_component`  
**Class:** `Drupal\layout_builder\Plugin\ConfigAction\AddComponent`  
**Source:** `core/modules/layout_builder/src/Plugin/ConfigAction/AddComponent.php`

## Attributes
- **id:** add_layout_component
- **admin_label:** Add component(s) to layout
- **deriver:** AddComponentDeriver::class

**Raw attribute:** `#[ConfigAction(id: 'add_layout_component',
  admin_label: new TranslatableMarkup('Add component(s) to layout'),
  deriver: AddComponentDeriver::class,)]`
