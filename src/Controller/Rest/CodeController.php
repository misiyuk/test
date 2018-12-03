<?php

namespace App\Controller\Rest;

use App\Helper\XlsCreator;
use App\UseCases\CodesService;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class CodeController
 * @package App\Controller\Rest
 *
 * @property CodesService $service
 */
class CodeController extends FOSRestController
{
    private $service;

    public function __construct(CodesService $service)
    {
        $this->service = $service;
    }

    /**
     * @Rest\Route("/generate", name="generate", methods={"POST"})
     * @Rest\RequestParam(name="nb", requirements="\d+", default="1", description="Count codes.")
     * @Rest\RequestParam(name="export", requirements="xls", default=null, nullable=true, description="Export type.")
     *
     * @param ParamFetcher $fetcher
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|JsonResponse
     * @throws \Throwable
     */
    public function generateAction(ParamFetcher $fetcher)
    {
        $nb = $fetcher->get('nb');
        $export = $fetcher->get('export');

        $this->service->generateCodes($nb);
        $codes = $this->service->getCodes();

        if ($export) {
            $xlsCreator = new XlsCreator();
            $xlsCreator->createTmpFile($codes);
            $tempFile = $xlsCreator->getTempFile();
            $fileName = $xlsCreator->getFileName();
            return $this->file($tempFile, $fileName);
        }

        return $this->json($codes);
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