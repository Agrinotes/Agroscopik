<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\FarmSpecialityMvtCategory;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadFarmSpecialityMvtCategories extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{

    /**
     * Load fixtures about Intervention Categories
     *
     * @param ObjectManager $em
     */
    public function load(ObjectManager $em)
    {
        $names = array(
            array('Achat', 'buyAction'),
            array('Utilisation', 'useAction'),
            array('Mise à jour de l\'inventaire', 'updateStockAction'),
        );

        foreach ($names as $name) {
            $category = new FarmSpecialityMvtCategory();
            $category->setName($name[0]);
            $em->persist($category);
        }

        $em->flush();
    }

    public function getOrder()
    {
        return 9;
    }
}