<?php

namespace FreezyBee\EditroubleBundle\Tests\Mock;

use FreezyBee\EditroubleBundle\Model\Storage\IStorage;

/**
 * Class TestStorage
 * @package FreezyBee\EditroubleBundle\Tests\Mock
 */
class TestStorage implements IStorage
{
    private static $data = [
        'namespaceX.en' => [
            'nameX' => 'contentX',
            'name"X' => '"te"st"'
        ],
        'namespaceX.cs' => [
            'nameX' => '<strong>hello czech!!!</strong>',
            'nameY' => '<strong>Do you like czech beer?</strong>'
        ]
    ];

    /**
     * @param $namespace
     * @param $locale
     * @return array
     */
    public function getNamespaceContent($namespace, $locale)
    {
        return self::$data[$namespace . '.' . $locale] ?? [];
    }

    /**
     * @param $namespace
     * @param $name
     * @param $locale
     * @param $content
     */
    public function saveContent($namespace, $name, $locale, $content)
    {
        self::$data[$namespace . '.' . $locale][$name] = $content;
    }
}
