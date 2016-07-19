<?php
// src/AppBundle/DataFixtures/ORM/LoadInterventions.php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Unit;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Intervention;


class LoadUnits extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Add default Interventions
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $names = array(
            array('surface_area','Acres','acre','4046.8564224','','','acre'),
            array('electric_current','Ampères','ampere','','','','A'),
            array('surface_area','Ares','are','100.0','','','a'),
            array('pressure','Bars','bar','100000.0','','','bar'),
            array('luminous_intensity','Candela','candela','','','','cd'),
            array('temperature','Celsius','celsius','','273.15','','°C'),
            array('none','Centaine','hundred','100.0','','','h.'),
            array('volume','Centilitres','centiliter','1.0e-05','','','cl'),
            array('volume_concentration','Centilitres par hectolitre','centiliter_per_hectoliter','1.0e-05','','0.1','cL/hL'),
            array('volume_concentration','Centilitres par litre','centiliter_per_liter','1.0e-05','','0.001','cL/L'),
            array('distance','Centimètres','centimeter','0.01','','','cm'),
            array('surface_area','Centimètres carré','square_centimeter','0.0001','','','cm²'),
            array('volume','Centimètres cube','cubic_centimeter','1.0e-06','','','cm³'),
            array('amount_of_substance','Centimoles','centimole','0.01','','','cmol'),
            array('amount_of_substance_density','Centimoles par kilogramme','centimole_per_kilogram','0.01','','','cmol/kg'),
            array('power','Cheval-vapeur anglais','english_horsepower','745.6998','','','hp'),
            array('power','Cheval-vapeur français','french_horsepower','735.5','','','ch'),
            array('angle','Degrés','degree','3.141592653589793','','180.0','°'),
            array('none','Douzaine','dozen','12.0','','','dz'),
            array('temperature','Farenheit','farenheit','1.8','459.67','','°F'),
            array('angle','Gradian','gradian','3.141592653589793','','200.0','gr'),
            array('mass','Grammes','gram','0.001','','','g'),
            array('mass_concentration','Grammes par hectolitre',' gram_per_hectoliter','0.01','','0.1','g/hL'),
            array('none','Grammes par kilogramme','gram_per_kilogram','','','10000.0','g/kg'),
            array('mass_concentration','Grammes par litre','gram_per_liter','0.01','','0.001','g/L'),
            array('mass_area_density','Grammes par mètre carré','gram_per_square_meter','0.001','','','g/m²'),
            array('surface_area','Hectares','hectare','10000.0','','','ha'),
            array('volume','Hectolitres','hectoliter','0.1','','','hL'),
            array('volume_area_density','Hectolitres par hectare','hectoliter_per_hectare','0.1','','10000.0','hL/ha'),
            array('pressure','Hectopascal','hectopascal','100.0','','','hPa'),
            array('time','Heures','hour','3600.0','','','h'),
            array('energy','Joules','joule','','','','J'),
            array('time','Jours','day','86400.0','','','d'),
            array('temperature','Kelvin','kelvin','','','','K'),
            array('mass','Kilogrammes','kilogram','','','','kg'),
            array('mass_area_density','Kilogrammes par hectare','kilogram_per_hectare','','','10000.0','kg/ha'),
            array('mass_concentration','Kilogrammes par hectolitre','kilogram_per_hectoliter','','','0.1','kg/hL'),
            array('mass_flow','Kilogrammes par jour','kilogram_per_day','','','86400.0','kg/d'),
            array('mass_concentration','Kilogrammes par litre','kilogram_per_liter','','','0.001','kg/L'),
            array('mass_area_density','Kilogrammes par mètre carré','kilogram_per_square_meter','','','','kg/m²'),
            array('mass_flow','Kilogrammes par seconde','kilogram_per_second','','','','kg/s'),
            array('distance','Kilomètres','kilometer','1000.0','','','km'),
            array('distance_speed','Kilomètres par heure','kilometer_per_hour','1000.0','','3600.0','km/h'),
            array('distance_speed','Kilomètres par seconde','kilometer_per_second','1000.0','','','km/s'),
            array('pressure','Kilopascal','kilopascal','1000.0','','','kPa'),
            array('power','Kilowatt','kilowatt','1000.0','','','kW'),
            array('energy','Kilowatt par heure','kilowatt_hour','3600000.0','','','kWh'),
            array('volume','Litres','liter','0.001','','','L'),
            array('volume_area_density','Litres par hectare','liter_per_hectare','0.001','','10000.0','L/ha'),
            array('volume_flow','Litres par heure','liter_per_hour','0.001','','3600.0','L/h'),
            array('volume_area_density','Litres par mètre carré','liter_per_square_meter','0.001','','','L/m²'),
            array('power','Mégawatt','megawatt','1000000.0','','','MW'),
            array('distance','Mètres','meter','','','','m'),
            array('surface_area','Mètres carré','square_meter','','','','m²'),
            array('volume','Mètres cube','cubic_meter','','','','m³'),
            array('volume_area_density','Mètres cube par hectare','cubic_meter_per_hectare','1.0e-06','','10000.0','cm³/ha'),
            array('distance_speed','Mètres par seconde','meter_per_second','','','','m/s'),
            array('mass','Microgrammes','microgram','1.0e-09','','','µg'),
            array('mass_concentration','Microgrammes par litre','microgram_per_liter','1.0e-06','','0.001','µg/L'),
            array('electric_current','Milliamperes','milliampere','0.001','','','mA'),
            array('none','Milliards','billion','1000000000.0','','','G.'),
            array('none','Milliardième','billionth','1.0e-09','','','n.'),
            array('mass_density','Milliards par gramme','billion_per_gram','1000000000.0','','1000.0','G./g'),
            array('none','Millième','thousandth','0.001','','','m.'),
            array('amount_of_substance','Milli-équivalent','milliequivalent','0.001','','','meq'),
            array('amount_of_substance_density','Milli-équivalent pour 100 grammes','milliequivalent_per_hundred_gram','0.1','','0.1','meq/100g'),
            array('none','Millier','thousand','1000.0','','','k.'),
            array('surface_area_density','Millier par hectare','thousand_per_hectare','1000.0','','10000.0','k./ha'),
            array('mass_density','Millier par hectogramme','thousand_per_hectogram','1000.0','','0.1','k./hg'),
            array('mass_density','Millier par kilogramme','thousand_per_kilogram','1000.0','','','k./kg'),
            array('concentration','Millier par litre','thousand_per_liter','1000.0','','0.001','k./L'),
            array('concentration','Millier par millilitre','thousand_per_milliliter','1000.0','','1.0e-06','k./mL'),
            array('mass','Milligrammes','milligram','1.0e-06','','','mg'),
            array('none','Milligrammes par kilogramme','milligram_per_kilogram','','','1000000.0','mg/kg'),
            array('mass_concentration','Milligrammes par litre','milligram_per_liter','0.001','','0.001','mg/L'),
            array('volume','Millilitres','milliliter','1.0e-06','','','mL'),
            array('volume_concentration','Millilitres par litre','milliliter_per_liter','1.0e-06','','0.001','mL/L'),
            array('distance','Millimètres','millimeter','0.001','','','mm'),
            array('distance_speed','Millimètres par heure','millimeter_per_hour','0.001','','3600.0','mm/h'),
            array('none','Millions','million','1000000.0','','','M.'),
            array('none','Millionième','millionth','1.0e-06','','','µ.'),
            array('concentration','Millions par litre','million_per_liter','1000000.0','','0.001','M./L'),
            array('time','Millisecondes','millisecond','0.001','','','ms'),
            array('time','Minutes','minute','60.0','','','min'),
            array('amount_of_substance','Moles','mole','','','','mol'),
            array('amount_of_substance_density','Mole par kilogramme','mole_per_kilogram','','','','mol/kg'),
            array('none','Partie par millions (ppm)','parts_per_million','','','1000000.0','ppm'),
            array('pressure','Pascal','pascal','','','','Pa'),
            array('none','Pourcents','percent','','','100.0','%'),
            array('none','Pourcentage de masse','mass_percent','','','100.0','%kg'),
            array('mass','Quintaux','quintal','100.0','','','qt'),
            array('mass_area_density','Quintaux par hectare','quintal_per_hectare','100.0','','10000.0','qt/ha'),
            array('angle','Radians','radian','','','','rad'),
            array('time','Seconde','second','','','','s'),
            array('mass','Tonnes','ton','1000.0','','','t'),
            array('mass_area_density','Tonnes par hectare','ton_per_hectare','1000.0','','10000.0','t/ha'),
            array('none','Unités','unity','','','','.'),
            array('surface_area_density','Unité par hectare','unity_per_hectare','','','10000.0','./ha'),
            array('mass_density','Unité par kilogramme','unity_per_kilogram','','','','./kg'),
            array('concentration','Unité par litre','unity_per_liter','','','0.001','./L'),
            array('surface_area_density','Unité par mètre carré','unity_per_square_meter','','','','./m²'),
            array('power','Watt','watt','','','','W'),
            array('heat_flux_density','Watt par mètre carré','watt_per_square_meter','','','','W/m²'),
        );

        foreach ($names as $name) {
            $unit = new Unit();
            $unit->setUnitCategory($this->getReference($name[0]));
            $unit->setName($name[1]);
            $unit->setSlug($name[2]);
            $unit->setA($name[3]);
            $unit->setB($name[4]);
            $unit->setC($name[5]);
            $unit->setSymbol($name[6]);
            $manager->persist($unit);

            // Needed to link this data to the other fixtures loaded
            $this->addReference($name[2], $unit);
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
