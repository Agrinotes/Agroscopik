<?php
// src/AppBundle/DataFixtures/ORM/LoadInterventions.php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Intervention;


class LoadInterventions extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Add default Interventions
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $names = array(
            array('Sous-solage','travail-du-sol'),
            array('Labour','travail-du-sol'),
            array('RotoLabour','travail-du-sol'),
            array('Rotavator','travail-du-sol'),
            array('Buttage','travail-du-sol'),
            array('Billonage','travail-du-sol'),
            array('Hersage','travail-du-sol'),
            array('Herse-étrille','travail-du-sol'),
            array('Cover-crop','travail-du-sol'),

            array('Semis pépinière','semis-et-plantation'),
            array('Semis direct','semis-et-plantation'),
            array('Greffage','semis-et-plantation'),
            array('Repiquage/Plantation','semis-et-plantation'),


            array('Paillage','amenagements-ecologiques-et-entretien'),
            array('Débroussaillage','amenagements-ecologiques-et-entretien'),
            array('Désherbage mécanique','amenagements-ecologiques-et-entretien'),
            array('Evacuation des déchets organiques','amenagements-ecologiques-et-entretien'),
            array('Enfouissement des résidus de culture','amenagements-ecologiques-et-entretien'),
            array('Arrachage/Destruction des cultures','amenagements-ecologiques-et-entretien'),
            array('Plantation de haie ou bosquet fleuri','amenagements-ecologiques-et-entretien'),
            array('Création de bande fleurie','amenagements-ecologiques-et-entretien'),
            array('Taille des arbres','amenagements-ecologiques-et-entretien'),
            array('Blanchiement des bâches','amenagements-ecologiques-et-entretien'),
            array('Nettoyage','amenagements-ecologiques-et-entretien'),
            array('Effeuillage','amenagements-ecologiques-et-entretien'),
            array('Palissage','amenagements-ecologiques-et-entretien'),
            array('Vide sanitaire sans produits','amenagements-ecologiques-et-entretien'),
            array('Lessivage des pains de coco','amenagements-ecologiques-et-entretien'),
            array('Mise en place des bobines de tuteurage','amenagements-ecologiques-et-entretien'),
            array('Désherbage manuel','amenagements-ecologiques-et-entretien'),

            array('Lâcher d\'auxiliaires','auxiliaires-de-culture'),
            array('Comptage d\'auxiliaires','auxiliaires-de-culture'),

            array('Fertilisation','fertilisation'),

            array('Traitement phytosanitaire','protection-des-cultures'),

            array('Irrigation ponctuelle','irrigation'),
            array('Irrigation régulière','irrigation'),

            array('Récolte','recolte'),

            array('Triage','travaux-post-recoltes'),

        );

        foreach ($names as $name) {
            $intervention = new Intervention();
            $intervention->setName($name[0]);
            $intervention->setInterventionCategory($this->getReference($name[1]));
            $manager->persist($intervention);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 2;
    }
}