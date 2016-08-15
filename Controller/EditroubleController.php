<?php

namespace FreezyBee\EditroubleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EditroubleController
 * @package FreezyBee\EditroubleBundle\Controller
 */
class EditroubleController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function updateAction(Request $request)
    {
        $role = $this->getParameter('editrouble.role');

        if ($this->isGranted($role)) {
            $data = json_decode($request->getContent());

            $contentProvider = $this->get('freezy_bee_editrouble.model.content_provider');

            foreach ($data as $item) {
                $contentProvider->saveContent(
                    $item->namespace,
                    $item->name,
                    $this->get('translator')->getLocale(),
                    $item->content
                );
            }

            return new Response();

        } else {
            return new Response('You do not have permission.', Response::HTTP_FORBIDDEN);
        }
    }
}
