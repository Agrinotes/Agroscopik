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
            array("5 10 25 (Litho)","engrais de fond","granulé","5","10","25","","4","","33","","","","",""),
            array("8 12 20 (Lithactyl 3 Pro)","engrais de fond","granulé","8","12","20","9","","","14","","0.2","","",""),
            array("10 3 28 (Lithammo)","engrais entretien","granulé","10","3","28","","","","27","","","","",""),
            array("10 12 24","engrais entretien","granulé","10","12","24","","","","","","0,2","","","Déconseillé sur fruitiers"),
            array("15 05 20","engrais entretien","granulé","15","5","20","","","","","","","","",""),
            array("16 26 00","engrais starter","granulé","16","26","0","8","","","11","","","","",""),
            array("17 17 17 ","engrais entretien","granulé","17","17","17","","","","2","","","","",""),
            array("8 12 20","engrais","granulé","8","12","20","9","","","14","","0,2","","",""),
            array("2 3 6 (Ab'Flor)","engrais","granulé","2","3","6","12","2","","","","12","","","Utilisable en Bio"),
            array("6 4 10 (Ab'Flor)","engrais","granulé","6","4","10","8","2","","","","10","","","Utilisable en Bio"),
            array("14N (Ab'Flor)","engrais","granulé","14","","","","","","","","","","","Utilisable en Bio"),
            array("Aloe Tech (NTS)","activateur de sol","liquide","14","","","","","","","","","","",""),
            array("Acide nitrique","acide","liquide","","","","","","","","","","","",""),
            array("Acide phosphorique","acide","","","","","","","","","","","","",""),
            array("BioFert","engrais","granulé","2.5","0.6","0.5","","","","","","","","","Présence d'oligo-éléments en faibles quantités"),
            array("Borax","engrais","granulé","","","","","","","","","","","",""),
            array("Cal-Tech (NTS)","engrais","liquide","11.3","0.25","0.62","13.3","","","","","0.5","","",""),
            array("Calcinit","engrais","granulé","15","0","0","26.5","","","","","","","",""),
            array("Calcimer T400","amendement","granule","0","0","0","36","2.5","","","","","","","Bio"),
            array("Chaux hydratée","amendement","poudre","","","","","","","","","","","",""),
            array("CPSP-90 (Hydrolisat de poisson)","engrais","poudre","13","0.6","","0.25","","","","","","","",""),
            array("Engrais Poisson","activateur de sol","liquide","3.5","0.75","0.25","1.14","","","","22.325","","","2.7","Bio"),
            array("Eurobio physalg 0  7 12","engrais de fond","granulé","0","7","12","34","","","","","","","","Bio"),
            array("Farine de sang","engrais","poudre","11.9","","","","","","","","","","",""),
            array("Fiente de volailles (Paddock Creek)","engrais","granulé","3","2","1.1","2.7","","","0.4","","","","",""),
            array("Fulvic 1400 (NTS)","engrais","liquide","","","","","","","","","","","",""),
            array("Fer DTPA","amendement","liquide","","","","","","4","","","","","",""),
            array("Fer EDTA","amendement","liquide","","","","","","6,5","","","","","",""),
            array("GreenMaster","engrais","liquide","","","","","","","","","","","",""),
            array("Gypse","amendement","poudre","0","0","0","30","","","14.5","","","","","Bio"),
            array("Humistart","amendement","granulé","4","0","0","33","2","","11","","","","",""),
            array("Huminature","amendement","granulé","","","","36","2.5","","","","","","",""),
            array("Hidromix","engrais hydroponie","poudre","","","","","","7","","0.6","0.65","3.3","0.27",""),
            array("Hydroflex c","engrais hydroponie","poudre","11","8","34","","3.2","","2.6","","","","",""),
            array("Hydroflex f","engrais hydroponie","poudre","10","11","32","","3.2","","2.6","","","","",""),
            array("Hydroflex l","engrais hydroponie","poudre","9","11","38","","3","","6.2","","","","",""),
            array("Hydroflex s","engrais hydroponie","poudre","10","9","33","","3.8","","4.2","","","","",""),
            array("Hydroflex t","engrais hydroponie","poudre","8","9","38","","3","","4","","","","",""),
            array("K-Carb-35 (NTS)","engrais","liquide","","","","","","","","","","","",""),
            array("Ksc 1","engrais","poudre","14","40","5","","","0.1","13","0,1","0.1","","",""),
            array("Ksc 3","engrais","poudre","15","5","35","","","0.1","","","0.1","","",""),
            array("Ksc 5","engrais","poudre","8","16","42","","","0.1","","0.1","0.1","","",""),
            array("Kthiolit","amendement","granulé","","","5","37","3","","4","","","","",""),
            array("Lithammo 5 10 25 ","engrais","granulé","5","10","25","","","","26","0.25","0.17","","",""),
            array("Maxifruit","engrais","liquide","3","7","7","","","","","0.1","","0.05","",""),
            array("MOP (Muriate of potash)","engrais","granulé","12","62","0","","","","","","","","",""),
            array("Map 12 62 00","engrais starter","poudre","12","62","0","","","","","","","","",""),
            array("MKP 0 52 34","engrais","poudre","0","51","34","","","","","","","","",""),
            array("Nitrabor","engrais","granulé","15","0","0","19","","","","","0.3","","",""),
            array("Nitrate de calcium granulé","engrais","granulé","15","0","0","26.5","","","","","","","",""),
            array("Nitrate de potasse ","engrais","granulé","13","0","46","","","","","","","","",""),
            array("NR5 Tourteau de Ricin","engrais","granulé","4","1.5","1.75","","","","","","","","","Utilisable en bio"),
            array("Nutri-Key Manganese Shuttle (NTS)","engrais","liquide","","","","","","","","","","","",""),
            array("Nutri-Key Zinc Shuttle (NTS)","engrais","liquide","","","","","","","","","","","",""),
            array("Nutri-Life 4-20 (NTS)","engrais","poudre","","","","","","","","","","","",""),
            array("Nutri-Life Myco-Force (NTS)","engrais","poudre","","","","","","","","","","","",""),
            array("Nutri-Life Root-Guard (NTS)","engrais","poudre","","","","","","","","","","","",""),
            array("Nutri-Life Trico-Shield (NTS)","engrais","poudre","","","","","","","","","","","",""),
            array("Nutri-Neem Oil EC 85% (NTS)","engrais","liquide","","","","","","","","","","","",""),
            array("Orgaliz F","engrais","granulé","14","0","0","","","","","","","","","Bio"),
            array("Organor ATB","amendement","granulé","2","1","1,5","","","","","","","","",""),
            array("Orga 9 7 00","amendement","granulé","9","7","0","","","","","","","","","Homologation en cours bio"),
            array("Orgasol 6 4 10","amendement","granulé","6","4","10","","","","9","","","","",""),
            array("Osmocote Exact","engrais","granulé","15","8","11","","2","0.45","","","","","","Bio"),
            array("Humisol 6 4 11","amendement","granulé","6","4","11","","","","","","","","","Homologation en cours bio"),
            array("Vegedor","amendement","granulé","2","0,6","0,8","","","","","","","","",""),
            array("Pac duo 22","engrais de fond","granulé","3","22","0","","","","18","","","","","Pour pH supérieur à 7"),
            array("Plantacote","engrais retard","granulé","14","8","14","","2","","10","","","","",""),
            array("Phylsalg 0 20 10","engrais de fond","granulé","0","20","10","24","1","","","","","","",""),
            array("Phylsalg 0 27 0","engrais de fond","granulé","0","27","0","45","","","","","","","","Bio, pour pH supérieur à 7"),
            array("Physiolith","amendement","granulé","0","0","0","36","2.5","","","","","","",""),
            array("Physiostart","engrais starter","micro granulé","8","28","0","","","","23","2","","","","20 à 25 kg / ha"),
            array("Rockphosphate","engrais de fond","poudre","0","29","0","40.5","0.3","0.4","1.6","","","","","Bio"),
            array("Solupotasse","engrais hydroponie","poudre","0","0","45","","","","","","","","",""),
            array("Sulfammo 23","engrais","granulé","23","0","0","","","","43","","","","",""),
            array("Sulfate de magnesium","amendement","","","","","","","","","","","","",""),
            array("Sulfate de potasse","engrais de fond","granulé","0","0","50","","","","18","","","","",""),
            array("Superphosphate","engrais","granulé","0","46","0","15","","","","","","","",""),
            array("Terraflex t","amendement","poudre","15","8","25","","2.1","","4","","","","",""),
            array("Urée","engrais","granulé","46","0","0","","","","","","","","",""),

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
