<?php

namespace Gdelre\SchemaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/_schema")
     */
    public function indexAction()
    {
        $data = $this->get('gdelre_schema.schema.extractor')->getSchema();
        $json_encoded = $this->get('serializer')->serialize($data, 'json');

        return new JsonResponse(json_decode($json_encoded, true));
    }
}
