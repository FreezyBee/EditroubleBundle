<?php

namespace FreezyBee\EditroubleBundle\Twig;

use FreezyBee\EditroubleBundle\Model\ContentProvider;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Translation\Translator;

/**
 * Class EditroubleExtension
 * @package FreezyBee\EditroubleBundle\Twig
 */
class EditroubleExtension extends \Twig_Extension
{
    /**
     * @var Translator
     */
    private $translator;

    /**
     * @var ContentProvider
     */
    private $contentProvider;

    /**
     * EditroubleExtension constructor.
     * @param Translator $translator
     * @param ContentProvider $contentProvider
     */
    public function __construct(Translator $translator, ContentProvider $contentProvider)
    {
        $this->translator = $translator;
        $this->contentProvider = $contentProvider;
    }

    /**
     * @inheritdoc
     */
    public function getTokenParsers()
    {
        return ['editrouble' => new EditroubleTokenParser()];
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'editrouble';
    }

    /**
     * @param $namespace
     * @param $name
     * @param UserInterface $user
     * @return string
     */
    public function getContext($namespace, $name, UserInterface $user = null)
    {
        $item = $this->contentProvider->getContent($namespace, $name, ['locale' => $this->translator->getLocale()]);

        if ($user && in_array('ROLE_ADMIN', $user->getRoles(), true)) {
            $json = json_encode(['namespace' => $namespace, 'name' => $name]);
            return '<div class="editrouble" data-editrouble=\'' . $json . '\'>' . $item . '</div>';
        } else {
            return $item;
        }
    }
}
