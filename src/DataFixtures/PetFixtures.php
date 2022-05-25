<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Pet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\Collections\Collection;

class PetFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {
        $adoptionCategory = $this->getReference(PetCategoryFixtures::ADOPTION_CATEGORY);
        $fosterCategory = $this->getReference(PetCategoryFixtures::FOSTER_CATEGORY);

        $papha = (new Pet())
            ->setName('Papha')
            ->setSpecies('cat')
            ->setDescription('a very good boy')
            ->setCategories(new ArrayCollection([$adoptionCategory]));

        $markiz = (new Pet())
            ->setName('Markiz')
            ->setSpecies('cat')
            ->setDescription('a very sweet boy')
            ->setCategories(new ArrayCollection([$fosterCategory]));

        $manager->persist($papha);
        $manager->persist($markiz);
        $manager->flush();
    }

    public function getDependencies(): array
    {
       return [
           PetCategoryFixtures::class,
       ];
    }
}
