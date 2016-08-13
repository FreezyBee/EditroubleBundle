<?php

namespace FreezyBee\EditroubleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EditroubleController
 * @package FreezyBee\EditroubleBundle\Controller
 */
class EditroubleController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateAction(Request $request)
    {
        $data = json_decode($request->getContent());

        $contentProvider = $this->get('freezy_bee_editrouble.model.content_provider');

        foreach ($data as $item) {
            $contentProvider->saveContent($item->namespace, $item->name, 'en', $item->content);
        }
        return new JsonResponse($data);
    }
}
