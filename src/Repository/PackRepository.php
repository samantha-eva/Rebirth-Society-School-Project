<?php

namespace App\Repository;

use App\Entity\Pack;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pack>
 */
class PackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pack::class);
    }

    /**
     * Récupère tous les packs en base de données
     *
     * @return Pack[]
     */
    public function findAllPacks(): array
    {
        // Utilisation de la méthode findAll() héritée de ServiceEntityRepository
        return $this->findAll();
    }

    public function findPackById(int $id): ?Pack
    {
        // Utilisation de find() pour récupérer un pack par son ID
        return $this->find($id);
    }

}
