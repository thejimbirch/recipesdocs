---
title: Drupal\Core\Config\Checkpoint\CheckpointStorage
source: core/lib/Drupal/Core/Config/Checkpoint/CheckpointStorage.php
---

# Drupal\Core\Config\Checkpoint\CheckpointStorage

**Source:** `core/lib/Drupal/Core/Config/Checkpoint/CheckpointStorage.php`

Provides a config storage that can make checkpoints.

## Notes

This storage wraps the active storage, and provides the ability to take
checkpoints. Once a checkpoint has been created all configuration operations
made after the checkpoint will be recorded, so it is possible to revert to
original state when the checkpoint was taken.

This class cannot be used to checkpoint another storage since it relies on
events triggered by the configuration system in order to work. It is the
responsibility of the caller to construct this class with the active storage.

  This API is experimental.

## Annotations

- `@internal`

