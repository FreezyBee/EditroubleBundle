<?php

namespace FreezyBee\EditroubleBundle\Tests\Twig;

use FreezyBee\EditroubleBundle\Model\ContentProvider;
use FreezyBee\EditroubleBundle\Tests\Mock\TestStorage;
use FreezyBee\EditroubleBundle\Twig\EditroubleExtension;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Translation\Translator;

/**
 * Class EditroubleExtensionTest
 * @package FreezyBee\EditroubleBundle\Tests\Twig
 */
class EditroubleExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testGetContentSimple()
    {
        $extension = $this->getExtension();

        $content = $extension->getContext('namespaceX', 'nameX');
        $this->assertEquals('contentX', $content);

        $content = $extension->getContext('namespaceX', 'nameY');
        $this->assertEquals('', $content);
    }

    /**
     * @return EditroubleExtension
     */
    private function getExtension()
    {
        $translator = new Translator('en');
        $contentProvider = new ContentProvider(new ArrayAdapter, new TestStorage);
        $secutiryChecker = $this->createMock(AuthorizationCheckerInterface::class);
        return new EditroubleExtension('ROLE_ADMIN', $translator, $secutiryChecker, $contentProvider);
    }
}
