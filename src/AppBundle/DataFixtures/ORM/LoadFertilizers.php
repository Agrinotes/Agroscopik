<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Fertilizer;


class LoadFertilizers extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Add default data for specialities
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $names = array(
            array("0 10 25","engrais de fond","granulé","0","10","25","22","1","","","","","","",""),
            array("0 32 16","engrais de fond","granulé","0","32","16","6,3","","","","","","","",""),
            array("10 12 24","engrais entretien","granulé","10","12","24","","","","","","0,2","","","Déconseillé sur fruitiers"),
            array("15 05 20","engrais entretien","granulé","15","5","20","","","","","","","","",""),
            array("16 26 00","engrais starter","granulé","16","26","0","8","","","11","","","","",""),
            array("17 17 17 ","engrais entretien","granulé","17","17","17","","","","2","","","","",""),
            array("8 12 20","engrais","granulé","8","12","20","9","","","14","","0,2","","",""),
            array("acide nitrique","acide","liquide","","","","","","","","","","","",""),
            array("acide phosphorique","acide","","","","","","","","","","","","",""),
            array("calcinit","engrais","granulé","15","0","0","26,5","","","","","","","",""),
            array("eurobio physalg 0  7 12","engrais de fond","granulé","0","7","12","34","","","","","","","","Bio"),
            array("fer dtpa","amendement","liquide","","","","","","4","","","","","",""),
            array("fer edta","amendement","liquide","","","","","","6,5","","","","","",""),
            array("gypse","amendement","poudre","0","0","0","30","","","14,5","","","","","Bio"),
            array("humistart","amendement","granulé","4","0","0","33","2","","11","","","","",""),
            array("hydroflex c","engrais hydroponie","poudre","11","8","34","","3,2","","2,6","","","","",""),
            array("hydroflex f","engrais hydroponie","poudre","10","11","32","","3,2","","2,6","","","","",""),
            array("hydroflex l","engrais hydroponie","poudre","9","11","38","","3","","6,2","","","","",""),
            array("hydroflex s","engrais hydroponie","poudre","10","9","33","","3,8","","4,2","","","","",""),
            array("hydroflex t","engrais hydroponie","poudre","8","9","38","","3","","4","","","","",""),
            array("ksc 1","engrais","poudre","14","40","5","","","0,1","13","0,1","0,1","","",""),
            array("ksc 3","engrais","poudre","15","5","35","","","0,1","","","0,1","","",""),
            array("ksc 5","engrais","poudre","8","16","42","","","0,1","","0,1","0,1","","",""),
            array("calcimer T400","amendement","granule","0","0","0","36","2,5","","","","","","","Bio"),
            array("lithammo 5 10 25 ","engrais","granulé","5","10","25","","","","26","0,25","0,17","","",""),
            array("map 12 62 00","engrais starter","poudre","12","62","0","","","","","","","","",""),
            array("mkp 0 52 34","engrais","poudre","0","51","34","","","","","","","","",""),
            array("nitrabor","engrais","granulé","15","0","0","19","","","","","0,3","","",""),
            array("nitrate de calcium granulé","engrais","granulé","15","0","0","26,5","","","","","","","",""),
            array("nitrate de potasse ","engrais","granulé","13","0","46","","","","","","","","",""),
            array("orgaliz F","engrais","granulé","14","0","0","","","","","","","","","Bio"),
            array("organor ATB","amendement","granulé","2","1","1,5","","","","","","","","",""),
            array("orga 9 7 00","amendement","granulé","9","7","0","","","","","","","","","Homologation en cours bio"),
            array("humisol 6 4 11","amendement","granulé","6","4","11","","","","","","","","","Homologation en cours bio"),
            array("vegedor","amendement","granulé","2","0,6","0,8","","","","","","","","",""),
            array("pac duo 22","engrais de fond","granulé","3","22","0","","","","18","","","","","Pour pH supérieur à 7"),
            array("plantacote","engrais retard","granulé","14","8","14","","2","","10","","","","",""),
            array("phylsalg 0 20 10","engrais de fond","granulé","0","20","10","24","1","","","","","","",""),
            array("phylsalg 0 27 0","engrais de fond","granulé","0","27","0","45","","","","","","","","Bio, pour pH supérieur à 7"),
            array("physiolith","amendement","granulé","0","0","0","36","2,5","","","","","","",""),
            array("physiostart","engrais starter","micro granulé","8","28","0","","","","23","2","","","","20 à 25 kg / ha"),
            array("rockphosphate","engrais de fond","poudre","0","29","0","40,5","0,3","0,4","1,6","","","","","Bio"),
            array("solupotasse","engrais hydroponie","poudre","0","0","45","","","","","","","","",""),
            array("sulfammo 23","engrais","granulé","23","0","0","","","","43","","","","",""),
            array("sulfate de magnesium","amendement","","","","","","","","","","","","",""),
            array("sulfate de potasse","engrais de fond","granulé","0","0","50","","","","18","","","","",""),
            array("superphosphate","engrais","granulé","0","46","0","15","","","","","","","",""),
            array("terraflex t","amendement","poudre","15","8","25","","2,1","","4","","","","",""),
            array("urée","engrais","granulé","46","0","0","","","","","","","","",""),
            array("Engrais Poisson","activateur de sol","liquide","3,5","0,75","0,25","1,14","","","","22,325","","","2,7","Bio"),

        );

        foreach ($names as $name) {
            $fertilizer = new Fertilizer();
            $fertilizer->setName($name[0]);
            $fertilizer->setType($name[1]);
            $fertilizer->setFormula($name[2]);

            $fertilizer->setN($name[3]);
            $fertilizer->setP2O5($name[4]);
            $fertilizer->setK2O($name[5]);
            $fertilizer->setCaO($name[6]);
            $fertilizer->setMgO($name[7]);
            $fertilizer->setFe($name[8]);
            $fertilizer->setSO3($name[9]);
            $fertilizer->setZn($name[10]);
            $fertilizer->setB($name[11]);
            $fertilizer->setMn($name[12]);
            $fertilizer->setCu($name[13]);

            $fertilizer->setComment($name[14]);

            $manager->persist($fertilizer);
        }

        $manager->flush();

    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 12;
    }
}
