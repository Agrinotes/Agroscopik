<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\UnitCategory;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadUnitCategories extends AbstractFixture implements FixtureInterface, OrderedFixtureInterface
{

    /**
     * Load fixtures about Intervention Categories
     *
     * @param ObjectManager $em
     */
    public function load(ObjectManager $em)
    {
        $names = array(
            array('Angle','angle','rad'),
            array('Aucune','none','.'),
            array('Concentration','concentration','./m³'),
            array('Concentration massique','mass_concentration','kg/m³'),
            array('Concentration volumique','volume_concentration','m³/m³'),
            array('Débit massique','mass_flow','kg/s'),
            array('Débit volumique','volume_flow','m³/s'),
            array('Densité de quantité de matière','amount_of_substance_density','mol/kg'),
            array('Densité surfacique','surface_area_density','./m²'),
            array('Distance','distance','m'),
            array('Énergie','energy','J'),
            array('Intensité','electric_current','A'),
            array('Intensité lumineuse','luminous_intensity','cd'),
            array('Masse','mass','kg'),
            array('Masse par unité de surface','mass_area_density','kg/m²'),
            array('Pression','pressure','N/m²'),
            array('Puissance','power','J/s'),
            array('Quantité de matière','amount_of_substance','mol'),
            array('Quantité de matière par unité de matière','mass_density','./kg'),
            array('Rayonnement solaire','heat_flux_density','W/m²'),
            array('Superficie','surface_area','m²'),
            array('Température','temperature','K'),
            array('Temps','time','s'),
            array('Vitesse (distance)','distance_speed','m/s'),
            array('Volume','volume','m³'),
            array('Volume par surface','volume_area_density','m³/m²'),
            array('Volume spécifique','specific_volume','m³/kg'),
        );

        foreach ($names as $name) {
            $category = new UnitCategory();
            $category->setName($name[0]);
            $category->setSlug($name[1]);
            $category->setSymbol($name[2]);
            $em->persist($category);

            // Needed to link this data to the other fixtures loaded
            $this->addReference($name[1], $category);
        }

        $em->flush();
    }

    public function getOrder()
    {
        return 9;
    }
}