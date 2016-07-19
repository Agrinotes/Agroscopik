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
            array('surface_area','Acre',' acre','4046.8564224','','','acre'),
            array('electric_current','Ampère',' ampere','','','','A'),
            array('surface_area','Are',' are','100.0','','','a'),
            array('pressure','Bar',' bar','100000.0','','','bar'),
            array('luminous_intensity','Candela',' candela','','','','cd'),
            array('temperature','Celsius',' celsius','','273.15','','°C'),
            array('none','Centaine',' hundred','100.0','','','h.'),
            array('volume','Centilitre',' centiliter','1.0e-05','','','cl'),
            array('volume_concentration','Centilitre par hectolitre',' centiliter_per_hectoliter','1.0e-05','','0.1','cL/hL'),
            array('volume_concentration','Centilitre par litre',' centiliter_per_liter','1.0e-05','','0.001','cL/L'),
            array('distance','Centimètre',' centimeter','0.01','','','cm'),
            array('surface_area','Centimètre carré',' square_centimeter','0.0001','','','cm²'),
            array('volume','Centimètre cube',' cubic_centimeter','1.0e-06','','','cm³'),
            array('amount_of_substance','Centimole',' centimole','0.01','','','cmol'),
            array('amount_of_substance_density','Centimole par kilogramme',' centimole_per_kilogram','0.01','','','cmol/kg'),
            array('power','Cheval-vapeur anglais',' english_horsepower','745.6998','','','hp'),
            array('power','Cheval-vapeur français',' french_horsepower','735.5','','','ch'),
            array('angle','Degré',' degree','3.141592653589793','','180.0','°'),
            array('none','Douzaine',' dozen','12.0','','','dz'),
            array('temperature','Farenheit',' farenheit','1.8','459.67','','°F'),
            array('angle','Gradian',' gradian','3.141592653589793','','200.0','gr'),
            array('mass','Gramme',' gram','0.001','','','g'),
            array('mass_concentration','Gramme par hectolitre',' gram_per_hectoliter','0.01','','0.1','g/hL'),
            array('none','Gramme par kilogramme',' gram_per_kilogram','','','10000.0','g/kg'),
            array('mass_concentration','Gramme par litre',' gram_per_liter','0.01','','0.001','g/L'),
            array('mass_area_density','Gramme par mètre carré',' gram_per_square_meter','0.001','','','g/m²'),
            array('surface_area','Hectare',' hectare','10000.0','','','ha'),
            array('volume','Hectolitre',' hectoliter','0.1','','','hL'),
            array('volume_area_density','Hectolitre par hectare',' hectoliter_per_hectare','0.1','','10000.0','hL/ha'),
            array('pressure','Hectopascal',' hectopascal','100.0','','','hPa'),
            array('time','Heure',' hour','3600.0','','','h'),
            array('energy','Joule',' joule','','','','J'),
            array('time','Jour',' day','86400.0','','','d'),
            array('temperature','Kelvin',' kelvin','','','','K'),
            array('mass','Kilogramme',' kilogram','','','','kg'),
            array('mass_area_density','Kilogramme par hectare',' kilogram_per_hectare','','','10000.0','kg/ha'),
            array('mass_concentration','Kilogramme par hectolitre',' kilogram_per_hectoliter','','','0.1','kg/hL'),
            array('mass_flow','Kilogramme par jour',' kilogram_per_day','','','86400.0','kg/d'),
            array('mass_concentration','Kilogramme par litre',' kilogram_per_liter','','','0.001','kg/L'),
            array('mass_area_density','Kilogramme par mètre carré',' kilogram_per_square_meter','','','','kg/m²'),
            array('mass_flow','Kilogramme par seconde',' kilogram_per_second','','','','kg/s'),
            array('distance','Kilomètre',' kilometer','1000.0','','','km'),
            array('distance_speed','Kilomètre par heure',' kilometer_per_hour','1000.0','','3600.0','km/h'),
            array('distance_speed','Kilomètre par seconde',' kilometer_per_second','1000.0','','','km/s'),
            array('pressure','Kilopascal',' kilopascal','1000.0','','','kPa'),
            array('power','Kilowatt',' kilowatt','1000.0','','','kW'),
            array('energy','Kilowatt par heure',' kilowatt_hour','3600000.0','','','kWh'),
            array('volume','Litre',' liter','0.001','','','L'),
            array('volume_area_density','Litre par hectare',' liter_per_hectare','0.001','','10000.0','L/ha'),
            array('volume_flow','Litre par heure',' liter_per_hour','0.001','','3600.0','L/h'),
            array('volume_area_density','Litre par mètre carré',' liter_per_square_meter','0.001','','','L/m²'),
            array('power','Mégawatt',' megawatt','1000000.0','','','MW'),
            array('distance','Mètre',' meter','','','','m'),
            array('surface_area','Mètre carré',' square_meter','','','','m²'),
            array('volume','Mètre cube',' cubic_meter','','','','m³'),
            array('volume_area_density','Mètre cube par hectare',' cubic_meter_per_hectare','1.0e-06','','10000.0','cm³/ha'),
            array('distance_speed','Mètre par seconde',' meter_per_second','','','','m/s'),
            array('mass','Microgramme',' microgram','1.0e-09','','','µg'),
            array('mass_concentration','Microgramme par litre',' microgram_per_liter','1.0e-06','','0.001','µg/L'),
            array('electric_current','Milliampere',' milliampere','0.001','','','mA'),
            array('none','Milliard',' billion','1000000000.0','','','G.'),
            array('none','Milliardième',' billionth','1.0e-09','','','n.'),
            array('mass_density','Milliard par gramme',' billion_per_gram','1000000000.0','','1000.0','G./g'),
            array('none','Millième',' thousandth','0.001','','','m.'),
            array('amount_of_substance','Milli-équivalent',' milliequivalent','0.001','','','meq'),
            array('amount_of_substance_density','Milli-équivalent pour 100 grammes',' milliequivalent_per_hundred_gram','0.1','','0.1','meq/100g'),
            array('none','Millier',' thousand','1000.0','','','k.'),
            array('surface_area_density','Millier par hectare',' thousand_per_hectare','1000.0','','10000.0','k./ha'),
            array('mass_density','Millier par hectogramme',' thousand_per_hectogram','1000.0','','0.1','k./hg'),
            array('mass_density','Millier par kilogramme',' thousand_per_kilogram','1000.0','','','k./kg'),
            array('concentration','Millier par litre',' thousand_per_liter','1000.0','','0.001','k./L'),
            array('concentration','Millier par millilitre',' thousand_per_milliliter','1000.0','','1.0e-06','k./mL'),
            array('mass','Milligramme',' milligram','1.0e-06','','','mg'),
            array('none','Milligramme par kilogramme',' milligram_per_kilogram','','','1000000.0','mg/kg'),
            array('mass_concentration','Milligramme par litre',' milligram_per_liter','0.001','','0.001','mg/L'),
            array('volume','Millilitre',' milliliter','1.0e-06','','','mL'),
            array('volume_concentration','Millilitre par litre',' milliliter_per_liter','1.0e-06','','0.001','mL/L'),
            array('distance','Millimètre',' millimeter','0.001','','','mm'),
            array('distance_speed','Millimètre par heure',' millimeter_per_hour','0.001','','3600.0','mm/h'),
            array('none','Million',' million','1000000.0','','','M.'),
            array('none','Millionième',' millionth','1.0e-06','','','µ.'),
            array('concentration','Million par litre',' million_per_liter','1000000.0','','0.001','M./L'),
            array('time','Milliseconde',' millisecond','0.001','','','ms'),
            array('time','Minute',' minute','60.0','','','min'),
            array('amount_of_substance','Mole',' mole','','','','mol'),
            array('amount_of_substance_density','Mole par kilogramme',' mole_per_kilogram','','','','mol/kg'),
            array('none','Partie par millions (ppm)',' parts_per_million','','','1000000.0','ppm'),
            array('pressure','Pascal',' pascal','','','','Pa'),
            array('none','Pourcent',' percent','','','100.0','%'),
            array('none','Pourcentage de masse',' mass_percent','','','100.0','%kg'),
            array('mass','Quintal',' quintal','100.0','','','qt'),
            array('mass_area_density','Quintal par hectare',' quintal_per_hectare','100.0','','10000.0','qt/ha'),
            array('angle','Radian',' radian','','','','rad'),
            array('time','Seconde',' second','','','','s'),
            array('mass','Tonne',' ton','1000.0','','','t'),
            array('mass_area_density','Tonne par hectare',' ton_per_hectare','1000.0','','10000.0','t/ha'),
            array('none','Unité',' unity','','','','.'),
            array('surface_area_density','Unité par hectare',' unity_per_hectare','','','10000.0','./ha'),
            array('mass_density','Unité par kilogramme',' unity_per_kilogram','','','','./kg'),
            array('concentration','Unité par litre',' unity_per_liter','','','0.001','./L'),
            array('surface_area_density','Unité par mètre carré',' unity_per_square_meter','','','','./m²'),
            array('power','Watt',' watt','','','','W'),
            array('heat_flux_density','Watt par mètre carré',' watt_per_square_meter','','','','W/m²'),
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
