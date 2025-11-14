---
title: Drupal\Core\Config\Action\Plugin\ConfigAction\EntityMethod
source: core/lib/Drupal/Core/Config/Action/Plugin/ConfigAction/EntityMethod.php
---

# Drupal\Core\Config\Action\Plugin\ConfigAction\EntityMethod

**Source:** `core/lib/Drupal/Core/Config/Action/Plugin/ConfigAction/EntityMethod.php`

Makes config entity methods with the ActionMethod attribute into actions.

## Notes

For example, adding the ActionMethod attribute to
\Drupal\user\Entity\Role::grantPermission() allows permissions to be added to
roles via config actions.

When calling \Drupal\Core\Config\Action\ConfigActionManager::applyAction()
the $data parameter is mapped to the method's arguments using the following
rules:
- If $data is not an array, the method must only have one argument or one
  required argument.
- If $data is an array and the method only accepts a single argument, the
  array will be passed to the first argument.
- If $data is an array and the method accepts more than one argument, $data
  will be unpacked into the method arguments.

  This API is experimental.

## Annotations

- `@internal`
- `@see \Drupal\Core\Config\Action\Attribute\ActionMethod`

