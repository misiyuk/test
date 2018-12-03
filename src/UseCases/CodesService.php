<?php

namespace App\UseCases;

use App\Entity\Codes;
use App\Helper\CodeGenerator;
use App\Repository\CodesRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CodesService
 * @package App\UseCases
 *
 * @property CodesRepository $repository
 * @property CodeGenerator $generator
 * @property EntityManager $em
 * @property array $codes
 */
class CodesService
{
    private $repository;
    private $generator;
    private $em;
    private $codes = [];

    public function __construct(CodesRepository $repository, CodeGenerator $generator, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->generator = $generator;
        $this->em = $em;
    }

    /**
     * @param string $code
     * @return Codes|null
     * @throws \Exception
     */
    public function create($code): ?Codes
    {
        if ($this->repository->get($code)) {
            return null;
        }
        $data = Codes::create($code);

        return $this->repository->save($data);
    }

    /**
     * @param $count
     * @throws \Throwable
     */
    public function generateCodes($count): void
    {
        $this->codes = [];
        $this->em->transactional(function () use ($count) {
            while (count($this->codes) < $count) {
                $code = $this->generator->generateCode();
                if ($this->create($code)) {
                    $this->codes[] = $code;
                }
            }
        });
    }

    public function getCodes(): array
    {
        return $this->codes;
    }
}