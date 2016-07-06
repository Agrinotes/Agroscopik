<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Crop;


class LoadCrops extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Add default data for crops
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $names = array(
            'Abricot',
            'Ail',
            'Ananas',
            'Anone ou Pomme-canelle',
            'Asperge',
            'Aubergine',
            'Avocat',
            'Banane',
            'Betterave',
            'Blé tendre',
            'Blé dur',
            'Cacao',
            'Café',
            'Canne à sucre',
            'Carambole',
            'Carotte',
            'Céléri',
            'Chouchoute',
            'Choux de Chine',
            'Choux kanak',
            'Choux-vert',
            'Citronelle',
            'Citron',
            'Citron vert',
            'Citrouille',
            'Clémentine',
            'Coco',
            'Colza',
            'Concombre',
            'Corosol',
            'Courge',
            'Cresson',
            'Dolique',
            'Fenouille',
            'Fève',
            'Fèverolle',
            'Figue',
            'Fraise',
            'Framboise',
            'Fruits à pain',
            'Gingembre',
            'Goyave',
            'Grenade',
            'Groseille',
            'Haricot',
            'Igname',
            'Patate douce',
            'Sorgho',
            'Laitue',
            'Lime',
            'Litchi',
            'Luzerne',
            'Maïs',
            'Maïs sucré',
            'Mandarine',
            'Mangue',
            'Manioc',
            'Menthe',
            'Millet',
            'Moutarde',
            'Myrtille',
            'Navet',
            'Noix de pécan',
            'Oignon',
            'Orange',
            'Papaye',
            'Pastèque',
            'Pêche',
            'Persil',
            'Piment doux',
            'Piment',
            'Plantain',
            'Poireau',
            'Pois',
            'Poivre',
            'Pommelo',
            'Pomme',
            'Pomme de terre',
            'Radis',
            'Raisin',
            'Rhubarbe',
            'Ricin',
            'Riz',
            'Roses',
            'Taro',
            'Tomate',
            'Tournesol',
            'Trèfle',
            'Vanille'
        );

        foreach ($names as $name) {
            $crop = new Crop();
            $crop->setName($name);
            $manager->persist($crop);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 3;
    }
}