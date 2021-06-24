<?php
/**
 * Photos fixtures.
 */
namespace App\DataFixtures;

use App\Entity\Photos;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class PhotosFixtures.
 */

class Photosfixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(100, 'Photos', function ($i) {
                $photos = new Photos();
                $photos->setTitle($this->faker->sentence);
                $photos->setText($this->faker->sentence);
                $photos->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
                $photos->setUpdatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));

                $photos->setGalleries($this->getRandomReference('Galleries'));

                return $photos;
        });
        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return array Array of dependencies
     */
    public function getDependencies(): array
    {
        return [Galleriesfixtures::class];
    }
}
