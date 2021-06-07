<?php
/**
 * Photos fixtures.
 */
namespace App\DataFixtures;

use App\Entity\Photos;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Class PhotosFixtures.
 */

class Photosfixtures extends Fixture
{
    /**
     * Faker.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Persistence object manager.
     *
     * @var \Doctrine\Persistence\ObjectManager
     */
    protected $manager;

    /**
     * Load.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Persistence object manager
     */
    public function load(ObjectManager $manager): void
    {
        $this->faker = Factory:: create();
        $this->manager = $manager;

        for ($i = 0; $i < 10; ++$i)
        {
            $Photos = new photos();
            $Photos->setTitle($this->faker->sentence);
            $Photos->setText($this->faker->sentence);
            $Photos->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $Photos->setUpdatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $this->manager->persist($Photos);

        }
        $manager->flush();
    }
}
