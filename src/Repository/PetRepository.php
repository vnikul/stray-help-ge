<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Pet;
use App\Entity\PetCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pet>
 *
 * @method PetCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method PetCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method PetCategory[]    findAll()
 * @method PetCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PetRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
	{
		parent::__construct($registry, PetCategory::class);
	}

	public function getPetByCategory(int $id)
	{
		$q = $this->_em->createQuery('SELECT p from App\Entity\Pet p WHERE :categoryID MEMBER OF p.categories');
		$q->setParameter('categoryID', $id);

		return $q->getResult();
	}

	/**
	 * @throws NonUniqueResultException
	 */
	public function getPetByID(string $id): Pet
	{
		$q = $this->_em->createQuery('SELECT p from App\Entity\Pet p WHERE p.id = :petID');
		$q->setParameter('petID', $id);

		return $q->getOneOrNullResult();
	}

	public function getAllPets(): array
	{
		return $this->_em->createQuery('SELECT p from App\Entity\Pet p')->getResult();
	}
}
