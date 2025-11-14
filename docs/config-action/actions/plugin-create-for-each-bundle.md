---
title: create_for_each_bundle
type: config-action-plugin
source: core/lib/Drupal/Core/Config/Action/Plugin/ConfigAction/CreateForEachBundle.php
---

# create_for_each_bundle

**Type:** Config action plugin (`ConfigAction` attribute)  
**Plugin ID:** `create_for_each_bundle`  
**Class:** `Drupal\Core\Config\Action\Plugin\ConfigAction\CreateForEachBundle`  
**Source:** `core/lib/Drupal/Core/Config/Action/Plugin/ConfigAction/CreateForEachBundle.php`

## Attributes
- **id:** create_for_each_bundle
- **admin_label:** Create entities for each bundle of an entity type
- **deriver:** CreateForEachBundleDeriver::class

**Raw attribute:** `#[ConfigAction(id: 'create_for_each_bundle',
  admin_label: new TranslatableMarkup('Create entities for each bundle of an entity type'),
  deriver: CreateForEachBundleDeriver::class,)]`
