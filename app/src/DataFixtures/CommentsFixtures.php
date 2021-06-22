<?php
/**
 * Comments fixture.
 */

namespace App\DataFixtures;

use App\Entity\Comments;
use Doctrine\Persistence\ObjectManager;

/**
 * Class CommentsFixtures.
 */
class CommentsFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param \Doctrine\Persistence\ObjectManager $manager Object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(3, 'Comments', function ($i) {
            $Comments = new Comments();
            $Comments->setNick($this->faker->word);
            $Comments->setEmail(sprintf('admin%d@example.com', $i));
            $Comments->setText($this->faker->sentence);
            $Comments->setCreatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $Comments->setUpdatedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));

            return $Comments;
        });

        $manager->flush();
    }
}