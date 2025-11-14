---
title: Drupal\Core\Config\Action\ConfigActionManager
source: core/lib/Drupal/Core/Config/Action/ConfigActionManager.php
---

# Drupal\Core\Config\Action\ConfigActionManager

**Source:** `core/lib/Drupal/Core/Config/Action/ConfigActionManager.php`

Information about the classes and interfaces that make up the Config Action
API.

## Notes

Configuration actions are plugins that manipulate simple configuration or
configuration entities. The configuration action plugin manager can apply
configuration actions. For example, the API is leveraged by recipes to create
roles if they do not exist already and grant permissions to those roles.

To define a configuration action in a module you need to:
- Define a Config Action plugin by creating a new class that implements the
  \Drupal\Core\Config\Action\ConfigActionPluginInterface, in namespace
  Plugin\ConfigAction under your module namespace. For more information about
  creating plugins, see the @link plugin_api Plugin API topic. @endlink
- Config action plugins use the attributes defined by
 \Drupal\Core\Config\Action\Attribute\ConfigAction. See the
  attributes.

Further information and examples:
- \Drupal\Core\Config\Action\Plugin\ConfigAction\EntityMethod derives
  configuration actions from config entity methods which have the
  \Drupal\Core\Config\Action\Attribute\ActionMethod attribute.
- \Drupal\Core\Config\Action\Plugin\ConfigAction\EntityCreate allows you to
  create configuration entities if they do not exist.
- \Drupal\Core\Config\Action\Plugin\ConfigAction\SimpleConfigUpdate allows
  you to update simple configuration using a config action.

  This API is experimental.

## Annotations

- `@defgroup config_action_api Config Action API`
- `@{`
- `@link attribute Attributes topic @endlink for more information about`
- `@}`
- `@internal`

