<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\InterventionCategory;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadInterventionCategories extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{

    /**
     * Load fixtures about Intervention Categories
     *
     * @param ObjectManager $em
     */
    public function load(ObjectManager $em)
    {
        $names = array(
            array('Travail du sol', 'travail-du-sol'),
            array('Semis et plantation', 'semis-et-plantation'),
            array('Aménagements écologiques et Entretien', 'amenagements-ecologiques-et-entretien'),
            array('Auxiliaires de cultures', 'auxiliaires-de-culture'),
            array('Fertilisation', 'fertilisation'),
            array('Protection des cultures', 'protection-des-cultures'),
            array('Irrigation', 'irrigation'),
            array('Observation', 'observation'),
            array('Récolte', 'recolte'),
            array('Travaux post-récoltes', 'travaux-post-recoltes'),
        );

        foreach ($names as $name) {
            $category = new InterventionCategory();
            $category->setName($name[0]);
            $em->persist($category);

            // Needed to link this data to the other fixtures loaded
            $this->addReference($name[1], $category);
        }

        $em->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}