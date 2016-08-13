<?php

namespace FreezyBee\EditroubleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="editrouble_content")
 */
class EditroubleContent
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $namespace;

    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $locale;

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * DoctrineEntity constructor.
     * @param $namespace
     * @param $name
     * @param $locale
     * @param $content
     */
    public function __construct($namespace, $name, $locale, $content)
    {
        $this->namespace = $namespace;
        $this->name = $name;
        $this->locale = $locale;
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }
}
