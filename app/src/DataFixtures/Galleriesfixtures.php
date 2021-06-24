<?php
/**
 * Galleries fixtures.
 */
namespace App\DataFixtures;

use App\Entity\Galleries;
use Doctrine\Persistence\ObjectManager;

/**
 * Class GalleriesFixtures.
 */

class Galleriesfixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
            $this->createMany(50, 'Galleries', function ($i) {
                    $galleries = new Galleries();
                    $galleries->setTitle($this->faker->word);
                    $galleries->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
                    $galleries->setUpdatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));

                return $galleries;
            });
        $manager->flush();
    }
}
