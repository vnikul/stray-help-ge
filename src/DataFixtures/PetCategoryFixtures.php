<?php

namespace App\DataFixtures;

use App\Entity\PetCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PetCategoryFixtures extends Fixture
{
    public const ADOPTION_CATEGORY = 'adoption';

    public const FOSTER_CATEGORY = 'fosterCare';

    public const SELL_CATEGORY = 'sell';


    public function load(ObjectManager $manager): void
    {
        $categories = [
            self::FOSTER_CATEGORY => (new PetCategory())->setType(self::ADOPTION_CATEGORY)->setSlug('adoption'),
            self::ADOPTION_CATEGORY => (new PetCategory())->setType(self::FOSTER_CATEGORY)->setSlug('foster-care'),
        ];

        foreach ($categories as $category) {
            $manager->persist($category);
        }

        $manager->persist((new PetCategory())->setType(self::SELL_CATEGORY)->setSlug('sell'));

        $manager->flush();

        foreach ($categories as $key => $category) {
            $this->addReference($key, $category);
        }
    }
}
