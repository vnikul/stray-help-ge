<?php

namespace App\DataFixtures;

use App\Entity\PetCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PetCategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $manager->persist((new PetCategory())->setType('adoption')->setSlug('adoption'));
        $manager->persist((new PetCategory())->setType('fosterCare')->setSlug('foster-care'));
        $manager->persist((new PetCategory())->setType('sell')->setSlug('sell'));

        $manager->flush();
    }
}
