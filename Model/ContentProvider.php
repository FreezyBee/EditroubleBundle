<?php

namespace FreezyBee\EditroubleBundle\Model;

use FreezyBee\EditroubleBundle\Model\Storage\IStorage;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Class BaseStorage
 * @package FreezyBee\EditroubleBundle\Model
 */
class ContentProvider
{
    /**
     * @var CacheItemPoolInterface
     */
    private $cache;

    /**
     * @var IStorage
     */
    private $storage;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * BaseStorage constructor.
     * @param CacheItemPoolInterface $cache
     * @param IStorage $storage
     */
    public function __construct(CacheItemPoolInterface $cache, IStorage $storage)
    {
        $this->cache = $cache;
        $this->storage = $storage;
    }

    /**
     * @param string $namespace
     * @param string $name
     * @param array $params
     * @return string
     */
    public function getContent($namespace, $name, array $params)
    {
        $locale = $params['locale'];
        $nKey = $namespace . '.' . $locale;

        return $this->loadedData[$nKey][$name] ?? $this->loadCachedNamespace($namespace, $name, $locale);
    }

    /**
     * @param $namespace
     * @param $name
     * @param $locale
     * @param $content
     */
    public function saveContent($namespace, $name, $locale, $content)
    {
        $this->storage->saveContent($namespace, $name, $locale, $content);
        $this->cache->deleteItem($namespace . '.' . $locale);
    }

    /**
     * @param $namespace
     * @param $name
     * @param $locale
     * @return string
     * @internal
     */
    public function loadCachedNamespace($namespace, $name, $locale)
    {
        $nKey = $namespace . '.' . $locale;

        if (!isset($this->loadedData[$nKey])) {
            // load namespace from cache
            $this->loadedData[$nKey] = $this->cache->getItem($nKey)->get();
        }

        if (isset($this->loadedData[$nKey][$name])) {
            // get content from php array
            return $this->loadedData[$nKey][$name];

        } else {
            // load namespace from database
            $this->loadedData[$nKey] = $data = $this->storage->getNamespaceContent($namespace, $locale);
            $this->saveCachedNamespace($namespace, $locale, $data);

            if (isset($this->loadedData[$nKey][$name])) {
                return $this->loadedData[$nKey][$name];

            } else {
                // insert new record (empty)
                $this->storage->saveContent($namespace, $name, $locale, '');
                return $this->loadedData[$nKey][$name] = '';
            }
        }
    }

    /**
     * @param $namespace
     * @param $locale
     * @param $data
     */
    public function saveCachedNamespace($namespace, $locale, $data)
    {
        $this->cache->save($this->cache->getItem($namespace . '.' . $locale)->set($data));
    }
}
