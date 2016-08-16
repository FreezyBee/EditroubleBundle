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
     *
     */
    public function testGetContentLogged()
    {
        $extension = $this->getExtension(true);

        $content = $extension->getContext('namespaceX', 'nameX');
        $exp = '<div class="editrouble" data-editrouble=\'{"namespace":"namespaceX","name":"nameX"}\'>contentX</div>';
        $this->assertEquals($exp, $content);

        $content = $extension->getContext('namespaceX', 'name"X');
        $exp = '<div class="editrouble" data-editrouble=\'{"namespace":"namespaceX","name":"name\"X"}\'>"te"st"</div>';
        $this->assertEquals($exp, $content);

        $extension = $this->getExtension(true, 'cs');

        $content = $extension->getContext('namespaceX', 'nameY');
        $exp = '<div class="editrouble" data-editrouble=\'{"namespace":"namespaceX","name":"nameY"}\'>' .
            '<strong>Do you like czech beer?</strong></div>';
        $this->assertEquals($exp, $content);
    }


    /**
     *
     */
    public function testGetContentEmpty()
    {
        $extension = $this->getExtension(true, 'en');

        $content = $extension->getContext('namespaceX', 'nameY');
        $exp = '<div class="editrouble" data-editrouble=\'{"namespace":"namespaceX","name":"nameY"}\'></div>';
        $this->assertEquals($exp, $content);

        $extension = $this->getExtension(true, 'cs');

        $content = $extension->getContext('namespaceX', 'nameZ');
        $exp = '<div class="editrouble" data-editrouble=\'{"namespace":"namespaceX","name":"nameZ"}\'></div>';
        $this->assertEquals($exp, $content);
    }

    /**
     * @param bool $isGranted
     * @param string $locale
     * @return EditroubleExtension
     */
    private function getExtension($isGranted = false, $locale = 'en')
    {
        $translator = new Translator($locale);
        $contentProvider = new ContentProvider(new ArrayAdapter, new TestStorage);
        $secutiryChecker = $this->createMock(AuthorizationCheckerInterface::class);
        $secutiryChecker->method('isGranted')
            ->willReturn($isGranted);

        return new EditroubleExtension('placeholder', 'ROLE_ADMIN', $translator, $secutiryChecker, $contentProvider);
    }
}
