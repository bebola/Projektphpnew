<?php
/**
 * Categories fixtures.
 */
namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Persistence\ObjectManager;

/**
 * Class CategoriesFixtures.
 */

class Categoriesfixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */

    public function loadData(ObjectManager $manager): void
    {
            $this->createMany(50, 'Categories', function ($i) {
                    $Categories = new Categories();
                    $Categories->setTitle($this->faker->word);
                    $Categories->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
                    $Categories->setUpdatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));

                return $Categories;
            }
            );
        $manager->flush();
    }
}
