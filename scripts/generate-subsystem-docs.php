#!/usr/bin/env php
<?php

declare(strict_types=1);

$root = dirname(__DIR__);
$docsDir = $root . '/docs';

$targets = [
    'config-action' => [
        'title' => 'Config Actions',
        'namespace' => 'Drupal\\Core\\Config\\Action',
        'source' => $root . '/core/lib/Drupal/Core/Config/Action',
    ],
    'config-checkpoint' => [
        'title' => 'Config Checkpoints',
        'namespace' => 'Drupal\\Core\\Config\\Checkpoint',
        'source' => $root . '/core/lib/Drupal/Core/Config/Checkpoint',
    ],
    'default-content' => [
        'title' => 'Default Content',
        'namespace' => 'Drupal\\Core\\DefaultContent',
        'source' => $root . '/core/lib/Drupal/Core/DefaultContent',
    ],
    'recipes-api' => [
        'title' => 'Recipe API',
        'namespace' => 'Drupal\\Core\\Recipe',
        'source' => $root . '/core/lib/Drupal/Core/Recipe',
    ],
];

$sectionOverviews = [
    'config-action' => [
        'title' => 'Config Actions Overview',
        'body' => "Config actions fuel Drupal recipes by exposing safe mutations on configuration entities. Use these actions to create, update, or clone configuration items without writing PHP. This overview explains when to reach for entity method actions versus bespoke plugins and links to the API reference below.",
    ],
    'config-checkpoint' => [
        'title' => 'Config Checkpoints Overview',
        'body' => "Configuration checkpoints snapshot the entire configuration state so you can compare, roll back, or audit changes. This overview explains how checkpoints are stored, when they are created, and which services keep their history consistent.",
    ],
    'default-content' => [
        'title' => 'Default Content Overview',
        'body' => "Default content services allow recipes and install profiles to ship curated content. Learn how exporters, importers, and events coordinate to serialize entities and seed a site during installation.",
    ],
    'recipes-api' => [
        'title' => 'Recipes API Overview',
        'body' => "The Recipes API orchestrates installing modules, importing config, and applying actions from a single recipe file. Use this overview to understand the Configurator classes, runner lifecycle, and extension points.",
    ],
];

$recipesOverviewIntro = [
    'title' => 'Recipes in Core Overview',
    'body' => "Core ships opinionated recipes for content types, media types, workflows, and starter configurations. Each recipe bundles module installs, configuration imports, and config actions. Use this overview as a guide before exploring individual recipes.",
];

$topLevelOverviews = [
    'subsystems' => [
        'path' => $docsDir . '/subsystems-overview.md',
        'title' => 'Subsystems Overview',
        'body' => "Subsystems group the low-level services that recipes rely on: config actions, checkpoints, default content, and the recipes runtime itself. Browse each subsystem before diving into the generated API reference.",
    ],
];

$attributeMetadata = collectAttributeMetadata($root, ['ActionMethod', 'ConfigAction']);
$actionMethodsRaw = array_values(array_filter($attributeMetadata, fn ($entry) => $entry['attribute'] === 'ActionMethod'));
$configActionPluginsRaw = array_values(array_filter($attributeMetadata, fn ($entry) => $entry['attribute'] === 'ConfigAction'));
$actionMethods = array_values(array_filter(array_map('formatActionMethod', $actionMethodsRaw)));
$configActionPlugins = array_values(array_filter(array_map('formatConfigActionPlugin', $configActionPluginsRaw)));

if (!is_dir($docsDir) && !mkdir($docsDir, 0775, true) && !is_dir($docsDir)) {
    throw new RuntimeException('Failed to create docs directory.');
}

writeTopLevelOverviews($topLevelOverviews);

$navSubsystems = [];
$recipesNavEntries = [];
$actionNavEntries = [];

foreach ($targets as $slug => $definition) {
    $source = $definition['source'];
    if (!is_dir($source)) {
        fwrite(STDERR, "Skipping missing source directory: {$source}\n");
        continue;
    }
    $destination = $docsDir . '/' . $slug;
    resetDirectory($destination);

    $pages = [];
    if (isset($sectionOverviews[$slug])) {
        $overviewPath = writeOverview($destination, $sectionOverviews[$slug]['title'], $sectionOverviews[$slug]['body']);
        $pages[] = [$sectionOverviews[$slug]['title'] => $slug . '/' . basename($overviewPath)];
    }

    $files = collectPhpFiles($source);

    foreach ($files as $file) {
        $parsed = parsePhpMetadata($file);
        if ($parsed === null) {
            continue;
        }
        [$namespace, $shortName, $docComment] = $parsed;
        if ($namespace === '' && isset($definition['namespace'])) {
            $namespace = $definition['namespace'];
        }
        $relativePath = ltrim(str_replace($root . '/', '', $file), '/');
        $className = $namespace ? $namespace . '\\' . $shortName : $shortName;
        $doc = normalizeDocblock($docComment);
        $filename = $shortName . '.md';
        $content = renderClassMarkdown($className, $relativePath, $doc);
        file_put_contents($destination . '/' . $filename, $content);
        $pages[] = [$shortName => $slug . '/' . $filename];
    }

    if ($slug === 'config-action') {
        writeConfigActionPages($destination, $actionMethods, $configActionPlugins);
        $listOverview = writeConfigActionListOverview($destination, $actionMethods, $configActionPlugins);
        $actionNavEntries = array_merge(
            array_map(fn ($method) => [$method['display_name'] => 'config-action/actions/' . $method['slug'] . '.md'], $actionMethods),
            array_map(fn ($plugin) => [$plugin['display_name'] => 'config-action/actions/' . $plugin['slug'] . '.md'], $configActionPlugins)
        );
        usort($actionNavEntries, fn ($a, $b) => strcmp(array_key_first($a), array_key_first($b)));
        array_unshift($actionNavEntries, ['Config Actions List Overview' => 'config-action/' . basename($listOverview)]);
    }

    if ($pages !== []) {
        $navSubsystems[] = [$definition['title'] => $pages];
    }
}

// Recipes (YAML-based).
$recipesNavEntries = generateRecipeDocs($root, $docsDir, $recipesOverviewIntro);

writeIndex($docsDir);
array_unshift($navSubsystems, ['Subsystems Overview' => 'subsystems-overview.md']);
writeMkdocsConfig($root, $navSubsystems, $recipesNavEntries, $actionNavEntries);

echo "Documentation updated.\n";

/**
 * Reset a directory before writing files.
 */
function resetDirectory(string $path): void
{
    if (is_dir($path)) {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($iterator as $file) {
            $file->isDir() ? rmdir($file->getPathname()) : unlink($file->getPathname());
        }
    } elseif (file_exists($path)) {
        unlink($path);
    }
    if (!is_dir($path) && !mkdir($path, 0775, true) && !is_dir($path)) {
        throw new RuntimeException("Unable to create directory {$path}");
    }
}

/**
 * Collect PHP files inside a directory.
 */
function collectPhpFiles(string $source): array
{
    $files = [];
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($source, FilesystemIterator::SKIP_DOTS)
    );
    foreach ($iterator as $file) {
        if ($file->isFile() && strtolower($file->getExtension()) === 'php') {
            $files[] = $file->getRealPath();
        }
    }
    sort($files);
    return $files;
}

/**
 * Parse namespace, class name, and docblock from a PHP file.
 */
function parsePhpMetadata(string $file): ?array
{
    $code = file_get_contents($file);
    if ($code === false) {
        return null;
    }

    $tokens = token_get_all($code);
    $namespace = '';
    $docComment = '';

    for ($i = 0, $max = count($tokens); $i < $max; $i++) {
        $token = $tokens[$i];
        if (is_array($token)) {
            [$id, $text] = $token;
            if ($id === T_NAMESPACE) {
                $namespace = readNamespace($tokens, $i + 1);
            } elseif ($id === T_DOC_COMMENT) {
                $docComment = $text;
            } elseif (in_array($id, [T_CLASS, T_INTERFACE, T_TRAIT])) {
                $name = readNextString($tokens, $i + 1);
                if ($name !== '') {
                    return [$namespace, $name, $docComment];
                }
            }
        }
    }
    return null;
}

function readNamespace(array $tokens, int $index): string
{
    $pieces = [];
    $allowed = [T_STRING, T_NS_SEPARATOR];
    if (defined('T_NAME_QUALIFIED')) {
        $allowed[] = T_NAME_QUALIFIED;
    }
    if (defined('T_NAME_FULLY_QUALIFIED')) {
        $allowed[] = T_NAME_FULLY_QUALIFIED;
    }
    for ($i = $index, $max = count($tokens); $i < $max; $i++) {
        $token = $tokens[$i];
        if (is_array($token) && in_array($token[0], $allowed, true)) {
            $pieces[] = $token[1];
        } elseif ($token === ';' || $token === '{') {
            break;
        }
    }
    return implode('', $pieces);
}

function readNextString(array $tokens, int $index): string
{
    for ($i = $index, $max = count($tokens); $i < $max; $i++) {
        $token = $tokens[$i];
        if (is_array($token) && $token[0] === T_STRING) {
            return $token[1];
        }
    }
    return '';
}

/**
 * Normalize a docblock into summary, description, and tags.
 */
function normalizeDocblock(?string $docComment): array
{
    if (!$docComment) {
        return [
            'summary' => 'Documentation not found in source file.',
            'description' => '',
            'tags' => [],
        ];
    }

    $doc = preg_replace('#^/\*\*|\*/$#', '', $docComment);
    $lines = preg_split('/\R/', (string) $doc);
    $clean = [];
    foreach ($lines as $line) {
        $line = preg_replace('/^\s*\*\s?/', '', $line);
        $clean[] = rtrim($line);
    }
    $cleanText = trim(implode("\n", $clean));
    $tags = [];
    $descriptionLines = [];
    foreach (explode("\n", $cleanText) as $line) {
        if (str_starts_with(trim($line), '@')) {
            $tags[] = trim($line);
        } else {
            $descriptionLines[] = $line;
        }
    }
    $descriptionText = trim(implode("\n", $descriptionLines));
    $parts = preg_split("/\n\s*\n/", $descriptionText, 2);
    $summary = trim($parts[0] ?? '');
    $details = trim($parts[1] ?? '');

    return [
        'summary' => $summary ?: 'Documentation not found in source file.',
        'description' => $details,
        'tags' => $tags,
    ];
}

/**
 * Render Markdown for a class/interface/trait.
 */
function renderClassMarkdown(string $className, string $relativePath, array $doc): string
{
    $summary = $doc['summary'] ?? '';
    $description = $doc['description'] ?? '';
    $tags = $doc['tags'] ?? [];
    $body = <<<MD
---
title: {$className}
source: {$relativePath}
---

# {$className}

**Source:** `{$relativePath}`

{$summary}

MD;

    if ($description !== '') {
        $body .= "\n## Notes\n\n" . $description . "\n\n";
    }

    if ($tags !== []) {
        $body .= "## Annotations\n\n";
        foreach ($tags as $tag) {
            $body .= "- `{$tag}`\n";
        }
        $body .= "\n";
    }

    return $body;
}

/**
 * Generate docs for YAML recipes.
 */
function generateRecipeDocs(string $root, string $docsDir, array $overviewInfo): array
{
    $recipesPath = $root . '/core/recipes';
    if (!is_dir($recipesPath)) {
        return [];
    }

    $destination = $docsDir . '/recipes';
    resetDirectory($destination);

    $overviewFile = writeOverview($destination, $overviewInfo['title'], $overviewInfo['body']);

    $directories = array_filter(glob($recipesPath . '/*'), 'is_dir');
    sort($directories);

    $nav = [];

    foreach ($directories as $dir) {
        $recipeFile = $dir . '/recipe.yml';
        if (!file_exists($recipeFile)) {
            continue;
        }
        $machineName = basename($dir);
        $title = extractYamlValue($recipeFile, 'name') ?? $machineName;
        $description = extractYamlValue($recipeFile, 'description') ?? '';
        $type = extractYamlValue($recipeFile, 'type') ?? '';
        $filename = $machineName . '.md';
        $relativePath = ltrim(str_replace($root . '/', '', $recipeFile), '/');
        $yamlContents = trim(file_get_contents($recipeFile) ?: '');
        $content = renderRecipeMarkdown($title, $machineName, $relativePath, $description, $type, $yamlContents);
        file_put_contents($destination . '/' . $filename, $content);
        $nav[] = [$title => 'recipes/' . $filename];
    }

    array_unshift($nav, [$overviewInfo['title'] => 'recipes/' . basename($overviewFile)]);
    return $nav;
}

function extractYamlValue(string $file, string $key): ?string
{
    $pattern = '/^' . preg_quote($key, '/') . ':\s*(.+)$/m';
    if (preg_match($pattern, file_get_contents($file) ?: '', $matches)) {
        return trim(trim($matches[1]), "'\"");
    }
    return null;
}

function writeConfigActionPages(string $destination, array $actionMethods, array $configActionPlugins): void
{
    $pagesDir = $destination . '/actions';
    resetDirectory($pagesDir);

    foreach ($actionMethods as $method) {
        $content = <<<MD
---
title: {$method['display_name']}
type: action-method
source: {$method['file']}
---

# {$method['display_name']}

**Type:** Entity method config action  
**Implements via:** `{$method['class']}::{$method['method']}()`  
**Source:** `{$method['file']}`

## Attributes

MD;

        foreach ($method['attributes'] as $key => $value) {
            $valueText = $value === '' ? '_Not set_' : $value;
            $content .= "- **{$key}:** {$valueText}\n";
        }
        $content .= "\n**Raw attribute:** `#[ActionMethod({$method['attribute_raw']})]`\n";
        file_put_contents($pagesDir . '/' . $method['slug'] . '.md', $content);
    }

    foreach ($configActionPlugins as $plugin) {
        $content = <<<MD
---
title: {$plugin['display_name']}
type: config-action-plugin
source: {$plugin['file']}
---

# {$plugin['display_name']}

**Type:** Config action plugin (`ConfigAction` attribute)  
**Plugin ID:** `{$plugin['plugin_id']}`  
**Class:** `{$plugin['class']}`  
**Source:** `{$plugin['file']}`

## Attributes

MD;
        foreach ($plugin['attributes'] as $key => $value) {
            $valueText = $value === '' ? '_Not set_' : $value;
            $content .= "- **{$key}:** {$valueText}\n";
        }
        $content .= "\n**Raw attribute:** `#[ConfigAction({$plugin['attribute_raw']})]`\n";
        file_put_contents($pagesDir . '/' . $plugin['slug'] . '.md', $content);
    }
}

function writeConfigActionListOverview(string $destination, array $actionMethods, array $configActionPlugins): string
{
    $methodRows = [];
    foreach ($actionMethods as $method) {
        $methodRows[] = sprintf(
            '| [%s](actions/%s.md) | `%s` | `%s` |',
            $method['display_name'],
            $method['slug'],
            $method['attribute_snippet'],
            $method['file']
        );
    }
    sort($methodRows);

    $pluginRows = [];
    foreach ($configActionPlugins as $plugin) {
        $pluginRows[] = sprintf(
            '| [%s](actions/%s.md) | `%s` | `%s` | `%s` |',
            $plugin['display_name'],
            $plugin['slug'],
            $plugin['class'],
            $plugin['attribute_snippet'],
            $plugin['file']
        );
    }
    sort($pluginRows);

    $methodTable = $methodRows ? implode("\n", $methodRows) : '| _None_ | | |';
    $pluginTable = $pluginRows ? implode("\n", $pluginRows) : '| _None_ | | |';

    $content = <<<MD
# Config Actions List Overview

This list exposes every configuration action that Drupal core makes available to recipes. Use it to find actions that modify configuration entities (`#[ActionMethod]`) or to discover higher-level plugins such as block placement and layout builder helpers.

Each entry links to a generated reference page showing the attribute values that define the action, its source file, and the underlying class or method powering it.

## Entity methods marked with `#[ActionMethod]`

| Action | Attribute | Source |
| --- | --- | --- |
{$methodTable}

## Config action plugins (`#[ConfigAction]`)

| Action | Class | Attribute | Source |
| --- | --- | --- | --- |
{$pluginTable}
MD;
    $path = $destination . '/list-overview.md';
    file_put_contents($path, $content);
    return $path;
}

function extractAttributeValue(string $arguments, string $key): ?string
{
    if (preg_match('/' . preg_quote($key, '/') . '\s*:\s*(["\'])(.+?)\1/', $arguments, $matches)) {
        return $matches[2];
    }
    return null;
}

function renderRecipeMarkdown(string $title, string $machineName, string $relativePath, string $description, string $type, string $yamlContents): string
{
    $body = <<<MD
---
title: {$title}
recipe: {$machineName}
source: {$relativePath}
---

# {$title}

**Machine name:** `{$machineName}`  
**Source:** `{$relativePath}`

{$description}

MD;

    if ($type !== '') {
        $body .= "## Type\n\n{$type}\n\n";
    }

    if ($yamlContents !== '') {
        $body .= "## YAML definition\n\n```yaml\n{$yamlContents}\n```\n";
    }

    return $body;
}

function writeIndex(string $docsDir): void
{
    $indexFile = $docsDir . '/index.md';
    if (!file_exists($indexFile)) {
        return;
    }
    $content = <<<MD
# Drupal Recipes Documentation

This site documents Drupal's recipes along with the configuration actions, checkpoints, default content services, and other subsystems that power them. Pages in the sidebar are generated automatically via `composer mk:docs`; edit the underlying PHP classes or recipe YAML files to update the content.
MD;
    file_put_contents($indexFile, $content);
}

function writeTopLevelOverviews(array $pages): void
{
    foreach ($pages as $page) {
        $dir = dirname($page['path']);
        if (!is_dir($dir) && !mkdir($dir, 0775, true) && !is_dir($dir)) {
            throw new RuntimeException("Unable to create directory {$dir}");
        }
        $content = "# {$page['title']}\n\n{$page['body']}\n";
        file_put_contents($page['path'], $content);
    }
}

function writeOverview(string $directory, string $title, string $body): string
{
    $content = "# {$title}\n\n{$body}\n";
    $path = $directory . '/overview.md';
    file_put_contents($path, $content);
    return $path;
}

function writeMkdocsConfig(string $root, array $navSubsystems, array $recipesNav, array $actionNav): void
{
    $baseFile = $root . '/mkdocs_base.yml';
    if (!file_exists($baseFile)) {
        throw new RuntimeException('mkdocs_base.yml is missing.');
    }

    $base = yaml_parse_file_native($baseFile);
    if (!isset($base['nav']) || !is_array($base['nav'])) {
        $base['nav'] = [];
    }
    $base['nav'] = array_values(array_filter(
        $base['nav'],
        fn ($entry) => !array_key_exists('Subsystems Overview', $entry) && !array_key_exists('Subsystems', $entry)
            && !array_key_exists('Recipes', $entry) && !array_key_exists('Config Actions List', $entry)
    ));
    if ($navSubsystems !== []) {
        $base['nav'][] = ['Subsystems' => $navSubsystems];
    }
    if ($recipesNav !== []) {
        $base['nav'][] = ['Recipes' => $recipesNav];
    }
    if ($actionNav !== []) {
        $base['nav'][] = ['Config Actions List' => $actionNav];
    } else {
        $base['nav'][] = ['Config Actions List' => 'config-action/list-overview.md'];
    }
    $yaml = dump_yaml($base);
    file_put_contents($root . '/mkdocs.yml', $yaml);
}

function slugify(string $value): string
{
    $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $value), '-'));
    return $slug !== '' ? $slug : sha1($value);
}

function interpretAttributeValue(?string $value)
{
    if ($value === null) {
        return null;
    }
    $value = trim($value);
    if ($value === '') {
        return '';
    }
    if (strcasecmp($value, 'TRUE') === 0) {
        return true;
    }
    if (strcasecmp($value, 'FALSE') === 0) {
        return false;
    }
    if (preg_match('/^([\'"`])(.*)\1$/s', $value, $matches)) {
        return $matches[2];
    }
    if (preg_match("/new\s+TranslatableMarkup\((['\"])(.+?)\\1/s", $value, $matches)) {
        return $matches[2];
    }
    return $value;
}

function formatActionMethod(array $entry): ?array
{
    if (!$entry['class'] || !$entry['method']) {
        return null;
    }
    $args = $entry['args'] ?? [];
    $methodName = $entry['method'];
    $displayName = $methodName;
    $pluralRaw = $args['pluralize'] ?? null;
    $nameRaw = $args['name'] ?? null;
    if ($nameRaw !== null) {
        $displayName = interpretAttributeValue($nameRaw) ?: $displayName;
    } else {
        if ($pluralRaw === null) {
            $displayName .= '(s)';
        } else {
            $pluralValue = interpretAttributeValue($pluralRaw);
            if ($pluralValue === false) {
                // Keep singular name.
            } elseif (is_string($pluralValue) && $pluralValue !== '') {
                $displayName = $pluralValue;
            } else {
                $displayName .= '(s)';
            }
        }
    }

    $adminLabel = isset($args['adminLabel']) ? interpretAttributeValue($args['adminLabel']) : '';
    $attributesList = [];
    foreach (['name', 'adminLabel', 'pluralize'] as $key) {
        if (isset($args[$key])) {
            $attributesList[$key] = interpretAttributeValue($args[$key]);
        }
    }

    return [
        'type' => 'action-method',
        'class' => $entry['class'],
        'method' => $methodName,
        'file' => $entry['file'],
        'attribute_raw' => $entry['arguments'],
        'attribute_snippet' => '#[ActionMethod(' . trim($entry['arguments']) . ')]',
        'display_name' => $displayName,
        'admin_label' => $adminLabel ?? '',
        'attributes' => $attributesList,
        'slug' => slugify($entry['class'] . '-' . $methodName),
    ];
}

function formatConfigActionPlugin(array $entry): ?array
{
    if (!$entry['class']) {
        return null;
    }
    $args = $entry['args'] ?? [];
    $pluginId = isset($args['id']) ? interpretAttributeValue($args['id']) : $entry['class'];
    $adminLabel = isset($args['admin_label']) ? interpretAttributeValue($args['admin_label']) : '';
    $attributesList = [];
    foreach ($args as $key => $value) {
        $attributesList[$key] = interpretAttributeValue($value) ?? $value;
    }

    return [
        'type' => 'config-action-plugin',
        'plugin_id' => is_string($pluginId) ? $pluginId : (string) $pluginId,
        'class' => $entry['class'],
        'file' => $entry['file'],
        'attribute_raw' => $entry['arguments'],
        'attribute_snippet' => '#[ConfigAction(' . trim($entry['arguments']) . ')]',
        'display_name' => is_string($pluginId) ? $pluginId : $entry['class'],
        'admin_label' => $adminLabel ?? '',
        'attributes' => $attributesList,
        'slug' => slugify('plugin-' . ($pluginId ?? $entry['class'])),
    ];
}

function collectAttributeMetadata(string $root, array $attributeNames): array
{
    $directories = [
        $root . '/core/lib/Drupal/Core',
        $root . '/core/modules',
    ];
    $results = [];
    foreach ($directories as $directory) {
        if (!is_dir($directory)) {
            continue;
        }
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS)
        );
        foreach ($iterator as $file) {
            if (!$file->isFile() || strtolower($file->getExtension()) !== 'php') {
                continue;
            }
            $relativePath = ltrim(str_replace($root . '/', '', $file->getRealPath()), '/');
            if (stripos($relativePath, '/tests/') !== false || stripos($relativePath, '/Test/') !== false) {
                continue;
            }
            $results = array_merge($results, parseAttributesFromFile($file->getRealPath(), $attributeNames, $root));
        }
    }
    return $results;
}

function parseAttributesFromFile(string $file, array $attributeNames, string $root): array
{
    $code = file_get_contents($file);
    if ($code === false) {
        return [];
    }
    $tokens = token_get_all($code);
    $namespace = '';
    $classStack = [];
    $pendingClass = null;
    $braceDepth = 0;
    $results = [];
    $relative = ltrim(str_replace($root . '/', '', $file), '/');

    for ($i = 0, $max = count($tokens); $i < $max; $i++) {
        $token = $tokens[$i];
        if (is_array($token)) {
            switch ($token[0]) {
                case T_NAMESPACE:
                    $namespace = readNamespace($tokens, $i + 1);
                    break;
                case T_CLASS:
                case T_INTERFACE:
                case T_TRAIT:
                    $pendingClass = readNextString($tokens, $i + 1);
                    break;
                case T_ATTRIBUTE:
                    [$attributeEntries, $i] = readAttributeGroup($tokens, $i);
                    $targetIndex = skipIgnorableTokens($tokens, $i + 1);
                    while ($targetIndex < count($tokens)) {
                        $lookahead = $tokens[$targetIndex];
                        if (is_array($lookahead) && in_array($lookahead[0], [T_WHITESPACE, T_COMMENT, T_DOC_COMMENT], true)) {
                            $targetIndex++;
                            continue;
                        }
                        if (is_array($lookahead) && in_array($lookahead[0], [T_PUBLIC, T_PROTECTED, T_PRIVATE, T_STATIC, T_FINAL, T_ABSTRACT, T_READONLY], true)) {
                            $targetIndex++;
                            continue;
                        }
                        break;
                    }
                    $targetToken = $tokens[$targetIndex] ?? null;
                    $targetType = null;
                    $targetName = null;
                    if (is_array($targetToken)) {
                        if ($targetToken[0] === T_FUNCTION) {
                            $targetType = 'method';
                            $targetName = readNextString($tokens, $targetIndex + 1);
                        } elseif (in_array($targetToken[0], [T_CLASS, T_INTERFACE, T_TRAIT], true)) {
                            $targetType = 'class';
                            $targetName = readNextString($tokens, $targetIndex + 1);
                        }
                    }
                    foreach ($attributeEntries as $entry) {
                        [$attributeName, $arguments] = parseAttributeEntry($entry);
                        if ($attributeName === null) {
                            continue;
                        }
                        $shortName = shortAttributeName($attributeName);
                        if (!in_array($shortName, $attributeNames, true)) {
                            continue;
                        }
                        $className = null;
                        if ($targetType === 'class' && $targetName) {
                            $className = $namespace ? $namespace . '\\' . $targetName : $targetName;
                        } elseif ($targetType === 'method' && $classStack !== []) {
                            $class = $classStack[array_key_last($classStack)];
                            $className = $class['namespace'] ? $class['namespace'] . '\\' . $class['name'] : $class['name'];
                        }
                        $results[] = [
                            'attribute' => $shortName,
                            'arguments' => $arguments,
                            'args' => parseAttributeArguments($arguments),
                            'file' => $relative,
                            'class' => $className,
                            'method' => $targetType === 'method' ? $targetName : null,
                        ];
                    }
                    break;
            }
        } elseif ($token === '{') {
            $braceDepth++;
            if ($pendingClass !== null) {
                $classStack[] = ['name' => $pendingClass, 'namespace' => $namespace, 'depth' => $braceDepth];
                $pendingClass = null;
            }
        } elseif ($token === '}') {
            if (!empty($classStack) && end($classStack)['depth'] === $braceDepth) {
                array_pop($classStack);
            }
            $braceDepth--;
        }
    }
    return $results;
}

function readAttributeGroup(array $tokens, int $index): array
{
    $content = '';
    $count = count($tokens);
    for ($i = $index + 1; $i < $count; $i++) {
        $token = $tokens[$i];
        $text = is_array($token) ? $token[1] : $token;
        if ($text === ']') {
            $entries = splitTopLevelEntries($content);
            return [$entries, $i];
        }
        $content .= $text;
    }
    return [[], $index];
}

function splitTopLevelEntries(string $content): array
{
    $parts = [];
    $current = '';
    $depth = 0;
    $length = strlen($content);
    for ($i = 0; $i < $length; $i++) {
        $ch = $content[$i];
        if ($ch === '(') {
            $depth++;
            $current .= $ch;
        } elseif ($ch === ')') {
            $depth--;
            $current .= $ch;
        } elseif ($ch === ',' && $depth === 0) {
            if (trim($current) !== '') {
                $parts[] = $current;
            }
            $current = '';
        } else {
            $current .= $ch;
        }
    }
    if (trim($current) !== '') {
        $parts[] = $current;
    }
    return $parts;
}

function parseAttributeEntry(string $entry): array
{
    if (preg_match('/^\s*([^(\s]+)\s*\((.*)\)\s*$/s', trim($entry), $matches)) {
        return [$matches[1], trim($matches[2])];
    }
    return [null, null];
}

function parseAttributeArguments(string $arguments): array
{
    $parts = splitTopLevelEntries($arguments);
    $result = [];
    foreach ($parts as $part) {
        if (preg_match('/^\s*([A-Za-z0-9_]+)\s*:\s*(.+)$/s', $part, $matches)) {
            $result[$matches[1]] = trim($matches[2]);
        } else {
            $result[] = trim($part);
        }
    }
    return $result;
}

function shortAttributeName(string $name): string
{
    $name = ltrim($name, '\\');
    if (str_contains($name, '\\')) {
        return substr($name, strrpos($name, '\\') + 1);
    }
    return $name;
}

function skipIgnorableTokens(array $tokens, int $index): int
{
    $count = count($tokens);
    for ($i = $index; $i < $count; $i++) {
        $token = $tokens[$i];
        if (is_array($token) && in_array($token[0], [T_WHITESPACE, T_COMMENT, T_DOC_COMMENT], true)) {
            continue;
        }
        return $i;
    }
    return $index;
}

/**
 * Minimal YAML loader supporting basic site config.
 */
function yaml_parse_file_native(string $file): array
{
    if (function_exists('yaml_parse_file')) {
        $parsed = yaml_parse_file($file);
        if (is_array($parsed)) {
            return $parsed;
        }
    }
    // Very small parser good enough for mkdocs_base.yml (key/value and nested arrays).
    $lines = file($file, FILE_IGNORE_NEW_LINES);
    $stack = [[]];
    $indentStack = [0];
    foreach ($lines as $rawLine) {
        if (trim($rawLine) === '' || str_starts_with(trim($rawLine), '#')) {
            continue;
        }
        $indent = strlen($rawLine) - strlen(ltrim($rawLine, ' '));
        while ($indent < end($indentStack)) {
            array_pop($stack);
            array_pop($indentStack);
        }
        $line = trim($rawLine);
        if (str_starts_with($line, '- ')) {
            $value = trim(substr($line, 2));
            $current = &$stack[count($stack) - 1];
            if (!is_array($current)) {
                $current = [];
            }
            if ($value === '') {
                $current[] = [];
                $stack[] = &$current[array_key_last($current)];
                $indentStack[] = $indent + 2;
            } elseif (strpos($value, ':') !== false) {
                [$mapKey, $mapValue] = array_map('trim', explode(':', $value, 2));
                $entry = [];
                if ($mapValue === '') {
                    $entry[$mapKey] = [];
                    $current[] = $entry;
                    $stack[] = &$current[array_key_last($current)][$mapKey];
                    $indentStack[] = $indent + 2;
                } else {
                    $entry[$mapKey] = parseYamlScalar($mapValue);
                    $current[] = $entry;
                }
            } else {
                $current[] = parseYamlScalar($value);
            }
            continue;
        }
        [$key, $value] = array_pad(explode(':', $line, 2), 2, '');
        $key = trim($key);
        $value = trim($value);
        $current = &$stack[count($stack) - 1];
        if ($value === '') {
            $current[$key] = [];
            $stack[] = &$current[$key];
            $indentStack[] = $indent + 2;
        } else {
            $current[$key] = parseYamlScalar($value);
        }
    }
    return $stack[0];
}

function parseYamlScalar(string $value)
{
    $value = trim($value, "'\"");
    if ($value === 'true') {
        return true;
    }
    if ($value === 'false') {
        return false;
    }
    if (is_numeric($value)) {
        return $value + 0;
    }
    return $value;
}

/**
 * Very small YAML dumper for mkdocs.yml.
 */
function dump_yaml($data, int $indent = 0): string
{
    if (!is_array($data)) {
        return formatYamlScalar($data);
    }
    $lines = [];
    $isAssoc = array_keys($data) !== range(0, count($data) - 1);
    foreach ($data as $key => $value) {
        $prefix = str_repeat(' ', $indent);
        if ($isAssoc) {
            if (is_array($value)) {
                $lines[] = $prefix . $key . ':';
                $lines[] = dump_yaml($value, $indent + 2);
            } else {
                $lines[] = $prefix . $key . ': ' . formatYamlScalar($value);
            }
        } else {
            if (is_array($value)) {
                $lines[] = $prefix . '-';
                $lines[] = dump_yaml($value, $indent + 2);
            } else {
                $lines[] = $prefix . '- ' . formatYamlScalar($value);
            }
        }
    }
    return implode("\n", $lines);
}

function formatYamlScalar($value): string
{
    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }
    if (is_numeric($value)) {
        return (string) $value;
    }
    if ($value === '') {
        return "''";
    }
    if (is_string($value) && str_starts_with($value, '!!python/')) {
        return $value;
    }
    if (preg_match('/[":]/', $value)) {
        return '"' . $value . '"';
    }
    return (string) $value;
}
