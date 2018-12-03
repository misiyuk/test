<?php

namespace App\Repository;

use App\Entity\Codes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Codes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Codes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Codes[]    findAll()
 * @method Codes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CodesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Codes::class);
    }

    /**
     * @param Codes $data
     * @return Codes
     * @throws \Exception
     */
    public function save(Codes $data): Codes
    {
        $em = $this->getEntityManager();
        try{
            $em->persist($data);
            $em->flush();
        } catch (\Exception $e) {
            throw new \Exception('Can\'t save code');
        }

        return $data;
    }

    /**
     * @param string $code
     * @return Codes|null
     */
    public function get($code): ?Codes
    {
        return $this->findOneBy(['code' => $code]);
    }
}
