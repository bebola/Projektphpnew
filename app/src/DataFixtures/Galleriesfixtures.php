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
                    $Galleries = new Galleries();
                    $Galleries->setTitle($this->faker->word);
                    $Galleries->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
                    $Galleries->setUpdatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));

                return $Galleries;
            }
            );
        $manager->flush();
    }
}
