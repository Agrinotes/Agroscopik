<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Insect;


class LoadInsects extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Add default data for crops
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $names = array(
            array('Amblyseius californicus'),
            array('Amblyseius cucumeris'),
            array('Amblyseius degenerans'),
            array('Amblyseius swirskii'),
            array('Anthocoris nemoralis'),
            array('Aphidius spp.'),
            array('Aphidoletes aphidimyza'),
            array('Bombus spp.'),
            array('Chrysopa carnea'),
            array('Coleoptera'),
            array('Dacnusa sibirica'),
            array('Diglyphus isaea'),
            array('Encarsia formosa'),
            array('Eretmocerus eremicus'),
            array('Eretmocerus spp.'),
            array('Euseius gallicus'),
            array('Feltiella acarisuga'),
            array('Hypoaspis spp.'),
            array('Macrolophus pygmaeus'),
            array('Nematodes'),
            array('Nesidiocoris tenuis'),
            array('Orius spp.'),
            array('Paecilomyces fumosoroseus'),
            array('Phytoseiulus persimilis'),
            array('Trichogramma ssp.'),
        );

        foreach ($names as $name) {
            $crop = new Insect();
            $crop->setName($name[0]);
            $crop->setLatin($name[0]);
            $manager->persist($crop);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 11;
    }
}
