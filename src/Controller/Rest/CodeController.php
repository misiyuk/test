<?php

namespace App\Controller\Rest;

use App\Helper\CodeGenerator;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\JsonResponse;

class CodeController extends FOSRestController
{
    /**
     * @Rest\Route("/generate", name="generate", methods={"POST"})
     * @Rest\RequestParam(name="nb", requirements="\d+", default="1", description="Count codes.")
     * @Rest\RequestParam(name="export", requirements="xls", default=null, nullable=true, description="Export type.")
     *
     * @param ParamFetcher $fetcher
     * @param CodeGenerator $generator
     * @return JsonResponse
     */
    public function generateAction(ParamFetcher $fetcher, CodeGenerator $generator)
    {
        return $this->json([
            'code' => $generator->generateCode(),
            $fetcher->get('export'),
            $fetcher->get('nb'),
        ]);
    }

    /**
     * @Rest\Route("/{code}", requirements={"code"="\w+"}, name="code", methods={"GET"})
     *
     * @param $code
     * @return JsonResponse
     */
    public function getAction($code)
    {
        return $this->json([$code]);
    }
}