<?php

namespace FreezyBee\EditroubleBundle\Twig;

use FreezyBee\EditroubleBundle\Model\ContentProvider;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\Translation\Translator;

/**
 * Class EditroubleExtension
 * @package FreezyBee\EditroubleBundle\Twig
 */
class EditroubleExtension extends \Twig_Extension
{
    /**
     * @var string
     */
    private $placeholder;

    /**
     * @var string
     */
    private $role;

    /**
     * @var Translator
     */
    private $translator;

    /**
     * @var ContentProvider
     */
    private $contentProvider;

    /**
     * @var AuthorizationCheckerInterface
     */
    private $securityChecker;

    /**
     * EditroubleExtension constructor.
     * @param string $placeholder
     * @param string $role
     * @param Translator $translator
     * @param AuthorizationCheckerInterface $securityChecker
     * @param ContentProvider $contentProvider
     */
    public function __construct(
        $placeholder,
        $role,
        Translator $translator,
        AuthorizationCheckerInterface $securityChecker,
        ContentProvider $contentProvider
    ) {
        $this->placeholder = $placeholder;
        $this->role = $role;
        $this->translator = $translator;
        $this->contentProvider = $contentProvider;
        $this->securityChecker = $securityChecker;
    }

    /**
     * @inheritdoc
     */
    public function getFunctions()
    {
        return [
            'get_editrouble_role' => new \Twig_SimpleFunction('get_editrouble_role', function () {
                return $this->role;
            }),
            'get_editrouble_placeholder' => new \Twig_SimpleFunction('get_editrouble_placeholder', function () {
                return $this->placeholder;
            })
        ];
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
     * @return string
     */
    public function getContext($namespace, $name)
    {
        $item = $this->contentProvider->getContent($namespace, $name, ['locale' => $this->translator->getLocale()]);

        try {
            if ($this->securityChecker->isGranted($this->role)) {
                $json = json_encode(['namespace' => $namespace, 'name' => $name]);

                return '<div class="editrouble" data-editrouble=\'' . $json . '\'>' . $item . '</div>';
            }

            return $item;

        } catch (AuthenticationCredentialsNotFoundException $e) {
            return $item;
        }
    }
}
