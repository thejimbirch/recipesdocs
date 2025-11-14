# Config Actions List Overview

This list exposes every configuration action that Drupal core makes available to recipes. Use it to find actions that modify configuration entities (`#[ActionMethod]`) or to discover higher-level plugins such as block placement and layout builder helpers.

Each entry links to a generated reference page showing the attribute values that define the action, its source file, and the underlying class or method powering it.

## Entity methods marked with `#[ActionMethod]`

| Action | Attribute | Source |
| --- | --- | --- |
| [allowLayoutOverrides](actions/drupal-layout-builder-entity-layoutbuilderentityviewdisplay-setoverridable.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Toggle overridable layouts'), pluralize: FALSE, name: 'allowLayoutOverrides')]` | `core/modules/layout_builder/src/Entity/LayoutBuilderEntityViewDisplay.php` |
| [disableLayoutBuilder](actions/drupal-layout-builder-entity-layoutbuilderentityviewdisplay-disablelayoutbuilder.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Disable Layout Builder'), pluralize: FALSE)]` | `core/modules/layout_builder/src/Entity/LayoutBuilderEntityViewDisplay.php` |
| [disable](actions/drupal-core-config-entity-configentitybase-disable.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Disable'), pluralize: FALSE)]` | `core/lib/Drupal/Core/Config/Entity/ConfigEntityBase.php` |
| [enableLayoutBuilder](actions/drupal-layout-builder-entity-layoutbuilderentityviewdisplay-enablelayoutbuilder.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Enable Layout Builder'), pluralize: FALSE)]` | `core/modules/layout_builder/src/Entity/LayoutBuilderEntityViewDisplay.php` |
| [enable](actions/drupal-core-config-entity-configentitybase-enable.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Enable'), pluralize: FALSE)]` | `core/lib/Drupal/Core/Config/Entity/ConfigEntityBase.php` |
| [grantPermission(s)](actions/drupal-user-entity-role-grantpermission.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Add permission to role'))]` | `core/modules/user/src/Entity/Role.php` |
| [hideComponent](actions/drupal-core-entity-entitydisplaybase-removecomponent.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Hide component'), name: 'hideComponent')]` | `core/lib/Drupal/Core/Entity/EntityDisplayBase.php` |
| [setComponent(s)](actions/drupal-core-entity-entitydisplaybase-setcomponent.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Add component to display'))]` | `core/lib/Drupal/Core/Entity/EntityDisplayBase.php` |
| [setDefaultValue](actions/drupal-core-field-fieldconfigbase-setdefaultvalue.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Set default value'), pluralize: FALSE)]` | `core/lib/Drupal/Core/Field/FieldConfigBase.php` |
| [setDescription](actions/drupal-core-field-fieldconfigbase-setdescription.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Set field description'), pluralize: FALSE)]` | `core/lib/Drupal/Core/Field/FieldConfigBase.php` |
| [setDescription](actions/drupal-media-entity-mediatype-setdescription.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Set description'), pluralize: FALSE)]` | `core/modules/media/src/Entity/MediaType.php` |
| [setDisplaySubmitted](actions/drupal-node-entity-nodetype-setdisplaysubmitted.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Set whether to display submission information'), pluralize: FALSE)]` | `core/modules/node/src/Entity/NodeType.php` |
| [setFieldMap](actions/drupal-media-entity-mediatype-setfieldmap.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Set field mapping'), pluralize: FALSE)]` | `core/modules/media/src/Entity/MediaType.php` |
| [setFilterConfig(s)](actions/drupal-filter-entity-filterformat-setfilterconfig.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Sets configuration for a filter plugin'))]` | `core/modules/filter/src/Entity/FilterFormat.php` |
| [setLabel](actions/drupal-core-field-fieldconfigbase-setlabel.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Set field label'), pluralize: FALSE)]` | `core/lib/Drupal/Core/Field/FieldConfigBase.php` |
| [setMessage](actions/drupal-contact-entity-contactform-setmessage.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Set contact form message'), pluralize: FALSE)]` | `core/modules/contact/src/Entity/ContactForm.php` |
| [setMultiple](actions/drupal-core-config-entity-configentitybase-set.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Set a value'), pluralize: 'setMultiple')]` | `core/lib/Drupal/Core/Config/Entity/ConfigEntityBase.php` |
| [setName](actions/drupal-language-entity-configurablelanguage-setname.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Set Language name'), pluralize: FALSE)]` | `core/modules/language/src/Entity/ConfigurableLanguage.php` |
| [setNewRevision](actions/drupal-node-entity-nodetype-setnewrevision.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Automatically create new revisions'), pluralize: FALSE)]` | `core/modules/node/src/Entity/NodeType.php` |
| [setPreviewMode](actions/drupal-node-entity-nodetype-setpreviewmode.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Set preview mode'), pluralize: FALSE)]` | `core/modules/node/src/Entity/NodeType.php` |
| [setRecipients](actions/drupal-contact-entity-contactform-setrecipients.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Set recipients'), pluralize: FALSE)]` | `core/modules/contact/src/Entity/ContactForm.php` |
| [setRedirectPath](actions/drupal-contact-entity-contactform-setredirectpath.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Set redirect path'), pluralize: FALSE)]` | `core/modules/contact/src/Entity/ContactForm.php` |
| [setRegion](actions/drupal-block-entity-block-setregion.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Set block region'), pluralize: FALSE)]` | `core/modules/block/src/Entity/Block.php` |
| [setReply](actions/drupal-contact-entity-contactform-setreply.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Set auto-reply message'), pluralize: FALSE)]` | `core/modules/contact/src/Entity/ContactForm.php` |
| [setRequired](actions/drupal-core-field-fieldconfigbase-setrequired.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Set whether field is required'), pluralize: FALSE)]` | `core/lib/Drupal/Core/Field/FieldConfigBase.php` |
| [setSettings](actions/drupal-core-field-fieldconfigbase-setsettings.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Set field settings'), pluralize: FALSE)]` | `core/lib/Drupal/Core/Field/FieldConfigBase.php` |
| [setStatus](actions/drupal-core-config-entity-configentitybase-setstatus.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Set status'), pluralize: FALSE)]` | `core/lib/Drupal/Core/Config/Entity/ConfigEntityBase.php` |
| [setTranslatable](actions/drupal-core-field-fieldconfigbase-settranslatable.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Set whether field is translatable'), pluralize: FALSE)]` | `core/lib/Drupal/Core/Field/FieldConfigBase.php` |
| [setWeight](actions/drupal-block-entity-block-setweight.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Set block weight'), pluralize: FALSE)]` | `core/modules/block/src/Entity/Block.php` |
| [setWeight](actions/drupal-contact-entity-contactform-setweight.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Set weight'), pluralize: FALSE)]` | `core/modules/contact/src/Entity/ContactForm.php` |
| [setWeight](actions/drupal-language-entity-configurablelanguage-setweight.md) | `#[ActionMethod(adminLabel: new TranslatableMarkup('Set weight'), pluralize: FALSE)]` | `core/modules/language/src/Entity/ConfigurableLanguage.php` |

## Config action plugins (`#[ConfigAction]`)

| Action | Class | Attribute | Source |
| --- | --- | --- | --- |
| [addNavigationBlock](actions/plugin-addnavigationblock.md) | `Drupal\navigation\Plugin\ConfigAction\AddNavigationBlock` | `#[ConfigAction(id: 'addNavigationBlock',
  admin_label: new TranslatableMarkup('Add navigation block'),)]` | `core/modules/navigation/src/Plugin/ConfigAction/AddNavigationBlock.php` |
| [add_layout_component](actions/plugin-add-layout-component.md) | `Drupal\layout_builder\Plugin\ConfigAction\AddComponent` | `#[ConfigAction(id: 'add_layout_component',
  admin_label: new TranslatableMarkup('Add component(s) to layout'),
  deriver: AddComponentDeriver::class,)]` | `core/modules/layout_builder/src/Plugin/ConfigAction/AddComponent.php` |
| [create_for_each_bundle](actions/plugin-create-for-each-bundle.md) | `Drupal\Core\Config\Action\Plugin\ConfigAction\CreateForEachBundle` | `#[ConfigAction(id: 'create_for_each_bundle',
  admin_label: new TranslatableMarkup('Create entities for each bundle of an entity type'),
  deriver: CreateForEachBundleDeriver::class,)]` | `core/lib/Drupal/Core/Config/Action/Plugin/ConfigAction/CreateForEachBundle.php` |
| [entity_create](actions/plugin-entity-create.md) | `Drupal\Core\Config\Action\Plugin\ConfigAction\EntityCreate` | `#[ConfigAction(id: 'entity_create',
  deriver: EntityCreateDeriver::class,)]` | `core/lib/Drupal/Core/Config/Action/Plugin/ConfigAction/EntityCreate.php` |
| [entity_method](actions/plugin-entity-method.md) | `Drupal\Core\Config\Action\Plugin\ConfigAction\EntityMethod` | `#[ConfigAction(id: 'entity_method',
  deriver: EntityMethodDeriver::class,)]` | `core/lib/Drupal/Core/Config/Action/Plugin/ConfigAction/EntityMethod.php` |
| [simpleConfigUpdate](actions/plugin-simpleconfigupdate.md) | `Drupal\Core\Config\Action\Plugin\ConfigAction\SimpleConfigUpdate` | `#[ConfigAction(id: 'simpleConfigUpdate',
  admin_label: new TranslatableMarkup('Simple configuration update'),)]` | `core/lib/Drupal/Core/Config/Action/Plugin/ConfigAction/SimpleConfigUpdate.php` |