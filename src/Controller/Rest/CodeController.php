<?php

namespace App\Controller\Rest;

use App\Helper\XlsCreator;
use App\Repository\CodesRepository;
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
 * @property CodesRepository $repository
 */
class CodeController extends FOSRestController
{
    private $service;

    public function __construct(CodesService $service, CodesRepository $repository)
    {
        $this->service = $service;
        $this->repository = $repository;
    }

    /**
     * @Rest\Route("/generate", name="generate", methods={"POST"})
     * @Rest\RequestParam(name="nb", requirements="\d+", default="1", description="Count codes.")
     * @Rest\RequestParam(name="export", requirements="xls", default=null, nullable=true, description="Export type.")
     *
     * @param ParamFetcher $fetcher
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|JsonResponse
     * @throws \Exception
     */
    public function generateAction(ParamFetcher $fetcher)
    {
        $nb = $fetcher->get('nb');
        $export = $fetcher->get('export');

        try{
            $this->service->generateCodes($nb);
        }catch (\Throwable $t){
            throw new \Exception('Can\'t generate codes.');
        }
        $codes = $this->service->getCodes();

        if ($export) {
            $xlsCreator = new XlsCreator();
            try{
                $xlsCreator->createTmpFile($codes);
            }catch (\Exception $e){
                throw new \Exception('Can\'t create .xls-file.');
            }
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
     * @throws \Exception
     */
    public function getAction($code)
    {
        try{
            $codeEntity = $this->repository->get($code);

            if ($codeEntity) {
                return $this->json([
                    'id' => $codeEntity->getId(),
                    'code' => $codeEntity->getCode(),
                    'date' => $codeEntity->getDate(),
                ]);
            }
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
        throw $this->createNotFoundException('Code not found');
    }
}