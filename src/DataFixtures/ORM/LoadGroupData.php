<?php

namespace App\DataFixtures\ORM;

use App\Entity\Group;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadGroupData
 * @package App\DataFixtures\ORM
 */
class LoadGroupData extends AbstractFixture implements OrderedFixtureInterface, ORMFixtureInterface
{
    /**
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $group = new Group();

        $group->setName('Test group');

        $manager->persist($group);
        $manager->flush();

        $this->addReference('test-group', $group);
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}
