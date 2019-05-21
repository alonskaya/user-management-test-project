<?php

namespace App\DataFixtures\ORM;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadUserData
 * @package App\DataFixtures\ORM
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ORMFixtureInterface
{
    /**
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user->setEmail('test@mailtest.com')
            ->setLastName('Lastname')
            ->setFirstName('Firstname')
            ->setState(false)
            ->setCreationDate(new \DateTime('-1 month'))
            ->setGroups([$manager->merge($this->getReference('test-group'))]);

        $manager->persist($user);
        $manager->flush();

        $this->addReference('test-user', $user);
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}
