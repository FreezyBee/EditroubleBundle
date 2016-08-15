<?php

namespace FreezyBee\EditroubleBundle\Tests\Controller;

use FreezyBee\EditroubleBundle\Controller\EditroubleController;
use FreezyBee\EditroubleBundle\Model\ContentProvider;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class EditroubleControllerTest
 * @package FreezyBee\EditroubleBundle\Tests\Controller
 */
class EditroubleControllerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * TODO wtf?
     */
    public function testUpdateAction()
    {
        return;
        $request = $this->createMock(Request::class);
        $request->expects($this->once())
            ->method('getContent')
            ->willReturn('[{"namespace":"namespaceX","name":"nameX","content":"contentX"}]');

        $contentProviderService = $this->getMockBuilder(ContentProvider::class)
            ->disableOriginalConstructor()
            ->getMock();

        $securityService = $this->createMock(AuthorizationCheckerInterface::class)
            ->expects($this->once())
            ->method('isGranted')
            ->willReturn(true);

        $container = $this->createMock(ContainerInterface::class);
        $container->expects($this->exactly(2))
            ->method('has')
            ->with($this->equalTo('security.authorization_checker'))
            ->willReturn($securityService);

        $container->expects($this->any())
            ->method('get')
            ->will($this->returnCallback(function ($name) use ($contentProviderService, $securityService) {
                switch ($name) {
                    case 'security.authorization_checker':
                        return $securityService;
                    case 'freezy_bee_editrouble.model.content_provider':
                        return $contentProviderService;
                    default:
                        throw new \PHPUnit_Framework_Exception;
                }
            }));

        $controller = new EditroubleController();
        $controller->setContainer($container);

        $controller->updateAction($request);
    }
}
