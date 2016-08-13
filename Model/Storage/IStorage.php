<?php

namespace FreezyBee\EditroubleBundle\Model\Storage;

/**
 * Interface IStorage
 * @package FreezyBee\EditroubleBundle\Model\Storage
 */
interface IStorage
{
    const STORAGE_KEY = 'editrouble';

    /**
     * @param $namespace
     * @param $locale
     * @return array
     */
    public function getNamespaceContent($namespace, $locale);

    /**
     * @param $namespace
     * @param $name
     * @param $locale
     * @param $content
     */
    public function saveContent($namespace, $name, $locale, $content);
}
