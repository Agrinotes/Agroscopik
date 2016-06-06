<?php
namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\Entity\User;

class LoadAdminUser implements FixtureInterface
{
    public function load(ObjectManager $em)
    {
        $user = new User();
        $user->setFirstName("farmer_first_name");
        $user->setLastName("farmer_last_name");
        $user->setEmail("admin@repair.nc");
        $user->setPlainPassword("admin");
        $user->setEnabled(true);

        $em->persist($user);
        $em->flush();

        $user->setRoles(array('ROLE_ADMIN'));
        $em->persist($user);
        $em->flush();
    }
}