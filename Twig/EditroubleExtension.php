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
    private $infoMessage;

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
     * @param string $infoMessage
     * @param string $role
     * @param Translator $translator
     * @param AuthorizationCheckerInterface $securityChecker
     * @param ContentProvider $contentProvider
     */
    public function __construct(
        $infoMessage,
        $role,
        Translator $translator,
        AuthorizationCheckerInterface $securityChecker,
        ContentProvider $contentProvider
    ) {
        $this->infoMessage = $infoMessage;
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
        return ['get_editrouble_role' => new \Twig_SimpleFunction('get_editrouble_role', function () {
            return $this->role;
        })];
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

                return '<div class="editrouble" data-editrouble=\'' . $json . '\'>' .
                ($item ? $item : $this->infoMessage) . '</div>';
            }

            return $item;

        } catch (AuthenticationCredentialsNotFoundException $e) {
            return $item;
        }
    }
}
