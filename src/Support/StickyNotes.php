<?php

namespace MityDigital\StatamicStickyNotes\Support;

use Statamic\Facades\Blueprint;
use Statamic\Facades\File;
use Statamic\Facades\Path;
use Statamic\Facades\YAML;
use Stringy\StaticStringy;

class StickyNotes
{
    public static function blueprint(): \Statamic\Fields\Blueprint
    {
        return Blueprint::make()->setContents([
            'sections' => [
                'main' => [
                    'fields' => [
                        [
                            'handle' => 'show',
                            'field' => [
                                'display' => __('statamic-sticky-notes::cp.show.display'),
                                'instructions' => __('statamic-sticky-notes::cp.show.instructions'),
                                'type' => 'toggle',
                                'inline_label' => __('statamic-sticky-notes::cp.show.hidden'),
                                'inline_label_when_true' => __('statamic-sticky-notes::cp.show.shown'),
                                'validate' => [
                                    'boolean',
                                ],
                            ],
                        ],
                        [
                            'handle' => 'heading',
                            'field' => [
                                'display' => __('statamic-sticky-notes::cp.heading.display'),
                                'instructions' => __('statamic-sticky-notes::cp.heading.instructions'),
                                'type' => 'text',
                                'validate' => [
                                    'required',
                                    'string',
                                ],
                            ],
                        ],
                        [
                            'handle' => 'intro',
                            'field' => [
                                'display' => __('statamic-sticky-notes::cp.intro.display'),
                                'instructions' => __('statamic-sticky-notes::cp.intro.instructions'),
                                'type' => 'text',
                                'validate' => [],
                            ],
                        ],
                        [
                            'handle' => 'content',
                            'field' => [
                                'display' => __('statamic-sticky-notes::cp.content.display'),
                                'instructions' => __('statamic-sticky-notes::cp.content.instructions'),
                                'type' => 'bard',
                                'buttons' => self::getBardButtons(),
                                'link_collections' => self::getBardLinkCollections(),
                                'container' => config('statamic-sticky-notes.content.container'),
                                'validate' => [
                                    'required',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    protected static function getBardButtons(): ?array
    {
        $config = config('statamic-sticky-notes.content.buttons');

        if ($config && is_array($config)) {
            return $config;
        }

        return null;
    }

    protected static function getBardLinkCollections(): ?array
    {
        $config = config('statamic-sticky-notes.content.link_collections');

        if ($config && is_array($config)) {
            return $config;
        }

        return null;
    }

    public static function svg($name, $attrs = null): string
    {
        if ($attrs) {
            $attrs = " class=\"{$attrs}\"";
        }

        $svg = StaticStringy::collapseWhitespace(
            File::get(Path::tidy(__DIR__."/../../resources/svg/{$name}.svg"))
        );

        return str_replace('<svg', sprintf('<svg%s', $attrs), $svg);
    }

    public static function save(array $payload): void
    {
        File::put(self::getPath(), YAML::dump($payload));
    }

    public static function getPath(): string
    {
        $path = config('statamic-sticky-notes.path');
        $filename = config('statamic-sticky-notes.filename');

        return $path.'/'.$filename.'.yaml';
    }

    public static function load(): array
    {
        return YAML::file(self::getPath())->parse();
    }
}
