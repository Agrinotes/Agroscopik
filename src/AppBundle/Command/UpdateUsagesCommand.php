<?php

namespace AppBundle\Command;

use AppBundle\Entity\Speciality;
use AppBundle\Entity\SpecialityUsage;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;

class UpdateUsagesCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        // Name and description for app/console command
        $this
            ->setName('update:pesticides:usages')
            ->setDescription('Update pesticides usages from CSV file')
            ->addArgument('path', InputArgument::OPTIONAL, 'The path to the csv file.', 'web/uploads/import/pesticides.csv')
            ->addOption(
                'amm',
                null,
                InputOption::VALUE_REQUIRED,
                'Set AMM (Autorisation Mise sur le marché) column number',
                2
            )
            ->addOption(
                'name',
                null,
                InputOption::VALUE_REQUIRED,
                'Set usage short number column number',
                11
            )
            ->addOption(
                'dose',
                null,
                InputOption::VALUE_REQUIRED,
                'Set dose column number',
                16
            )
            ->addOption(
                'status',
                null,
                InputOption::VALUE_REQUIRED,
                'Set dose column number',
                15
            )
            ->addOption(
                'short-number',
                null,
                InputOption::VALUE_REQUIRED,
                'Set usage short number column number',
                10
            )
            ->addOption(
                'no-short-number',
                null,
                InputOption::VALUE_NONE,
                'Use if no usage short number in csv file'
            )

            ->addOption(
                'min-stage',
                null,
                InputOption::VALUE_REQUIRED,
                'Set usage minimum BBCH stage column number',
                13
            )
            ->addOption(
                'no-min-stage',
                null,
                InputOption::VALUE_NONE,
                'Use if no usage minimum BBCH stage in csv file'
            )
            ->addOption(
                'max-stage',
                null,
                InputOption::VALUE_REQUIRED,
                'Set usage maximum BBCH stage column number',
                14
            )
            ->addOption(
                'no-max-stage',
                null,
                InputOption::VALUE_NONE,
                'Use if no usage maximum BBCH stage in csv file'
            )
            ->addOption(
                'full-unit',
                null,
                InputOption::VALUE_REQUIRED,
                'Set full unit stage column number',
                17
            )
            ->addOption(
                'dar',
                null,
                InputOption::VALUE_REQUIRED,
                'Set Délai avant Récolte column number',
                18
            )
            ->addOption(
                'no-dar',
                null,
                InputOption::VALUE_NONE,
                'Use if no Délai avant Récolte in csv file'
            )
            ->addOption(
                'max-actions',
                null,
                InputOption::VALUE_REQUIRED,
                'Set maximum number of actions for current usage column number',
                20
            )
            ->addOption(
                'no-max-actions',
                null,
                InputOption::VALUE_NONE,
                'Use if no maximum number of actions for current usage in csv file'
            )
            ->addOption(
                'conditions',
                null,
                InputOption::VALUE_REQUIRED,
                'Set usage conditions column number',
                23
            )
            ->addOption(
                'no-conditions',
                null,
                InputOption::VALUE_NONE,
                'Use if no usage conditions in csv file'
            )
            ->addOption(
                'znt-water',
                null,
                InputOption::VALUE_REQUIRED,
                'Set znt water column number',
                24
            )
            ->addOption(
                'no-znt-water',
                null,
                InputOption::VALUE_NONE,
                'Use if no znt water in csv file'
            )
            ->addOption(
                'znt-arthropodes',
                null,
                InputOption::VALUE_REQUIRED,
                'Set znt arthropodes column number',
                25
            )
            ->addOption(
                'no-znt-arthropodes',
                null,
                InputOption::VALUE_NONE,
                'Use if no znt arthropodes in csv file'
            )
            ->addOption(
                'znt-plants',
                null,
                InputOption::VALUE_REQUIRED,
                'Set znt plants column number',
                26
            )
            ->addOption(
                'no-znt-plants',
                null,
                InputOption::VALUE_NONE,
                'Use if no znt arthropodes in csv file'
            );

    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {

        // Showing when the script is launched
        $start = new \DateTime();

        // Importing CSV on DB via Doctrine ORM
        $this->import($input, $output);

        // Showing when the script is over
        $end = new \DateTime();

        $output->writeln('<comment>Start : ' . $start->format('d-m-Y G:i:s') . ' ---</comment>');
        $output->writeln('<comment>End : ' . $end->format('d-m-Y G:i:s') . ' ---</comment>');
    }

    protected function import(InputInterface $input, OutputInterface $output)
    {
        // Getting php array of data from CSV
        $data = $this->get($input, $output);

        // Define column numbers
        $amm = $input->getOption('amm');
        $name = $input->getOption('name');
        $shortNumber = $input->getOption('no-short-number') ? false : $input->getOption('short-number');
        $minStage = $input->getOption('no-min-stage') ? false : $input->getOption('min-stage');
        $maxStage= $input->getOption('no-max-stage') ? false : $input->getOption('max-stage');
        $dar= $input->getOption('no-dar') ? false : $input->getOption('dar');
        $maxActions= $input->getOption('no-max-actions') ? false : $input->getOption('max-actions');
        $conditions= $input->getOption('no-conditions') ? false : $input->getOption('conditions');
        $zntWater= $input->getOption('no-znt-water') ? false : $input->getOption('znt-water');
        $zntArthropodes= $input->getOption('no-znt-arthropodes') ? false : $input->getOption('znt-arthropodes');
        $zntPlants= $input->getOption('no-znt-plants') ? false : $input->getOption('znt-plants');
        $status= $input->getOption('status');
        $dose= $input->getOption('dose');
        $fullUnit = $input->getOption('full-unit');


        // Getting doctrine manager
        $em = $this->getContainer()->get('doctrine')->getManager();
        // Turning off doctrine default logs queries for saving memory
        $em->getConnection()->getConfiguration()->setSQLLogger(null);

        // Define the size of record, the frequency for persisting the data and the current index of records
        $size = count($data);

        $batchSize = 50;
        $i = 1;
        $added = 0;
        $dismissed = 0;

        // Starting progress
        $progress = new ProgressBar($output, $size);
        $progress->start();

        // Processing on each row of data
        foreach ($data as $row) {

            // Find line speciality
            $speciality = $em->getRepository('AppBundle:Speciality')
                ->findByAmm(intval($row[$amm]));


            // If the pesticide isn't found just dismiss it
            if (!is_object($speciality)) {

                // Build a usage object based on csv to compare to current usages
                $csvUsage = new SpecialityUsage();

                // Attach speciality to this usage
                $csvUsage->setSpeciality($speciality);

                // Add usage short number
                if($shortNumber){
                    $csvUsage->setShortNumber($row[$shortNumber]);
                }

                // Add usage name (required)
                $csvUsage->setName($row[$name]);

                // Add min and max BBCH crop stage for usage
                if($minStage){
                    $csvUsage->setMinCropStage($row[$minStage]);
                }
                if($maxStage){
                    $csvUsage->setMaxCropStage($row[$maxStage]);
                }

                if($dar){
                    $csvUsage->setDAR($row[$dar]);
                }
                if($maxActions){
                    $csvUsage->setMaxActions($row[$maxActions]);
                }

                if($conditions){
                    $csvUsage->setConditions($row[$conditions]);
                }

                if($zntWater){
                    $csvUsage->setZNTwater($row[$zntWater]);
                }

                if($zntArthropodes){
                    $csvUsage->setZNTarthropodes($row[$zntArthropodes]);
                }

                if($zntPlants){
                    $csvUsage->setZNTplants($row[$zntPlants]);
                }

                // Guess status (required)
                if($row[$status]=="Autorisé"){
                    $csvUsage->setStatus("TRUE");
                }else{
                    $csvUsage->setStatus("FALSE");
                }

                // Add dose (required)
                $csvUsage->setDose($row[$dose]);

                // Add full unit (required)
                $csvUsage->setFullUnit($row[$fullUnit]);

                // Guess unit categories from $fullUnit

                // Get first part of the csvUnit string
                $csvUnit1 = strtok($row[$fullUnit], '/');
                $unit = $em->getRepository('AppBundle:Unit')->findOneBySymbol($csvUnit1);

                if (is_object($unit)) {
                    // If unit exists, attribute it to usage
                    $csvUsage->setUnit1($unit);
                } else {
                    // If nothing is found, attribute "unit" unit.
                    $unityCategory = $em->getRepository('AppBundle:Unit')->findOneBySlug('unity');
                    $csvUsage->setUnit1($unityCategory);
                }

                //Get second part of the unit
                $csvUnitSecondPart = substr($row[$fullUnit], strrpos($row[$fullUnit], '/') + 1);

                // Extract numbers if any to fill amount unit
                $csvAmountUnit2 = preg_replace("/[^0-9]+/", "", $csvUnitSecondPart);
                   if($csvAmountUnit2){
                       $csvUsage->setAmountUnit2($csvAmountUnit2);
                   } else{
                       $csvUsage->setAmountUnit2(0);
                   }

                // Extract letters if any to guess unit
                $csvUnit2 = preg_replace("/[^a-zA-Z]+/", "", $csvUnitSecondPart);

                // Test if non empty (checks if amount unit is also non empty oherwise attributes unit unit)
                if($csvUnit2 != "" || $csvAmountUnit2 != ""){
                    $unit2 = $em->getRepository('AppBundle:Unit')->findOneBySymbol($csvUnit2);

                    // If we found a matching unit
                    if(is_object($unit2)){
                        $csvUsage->setUnit2($unit2);
                    }else{
                        // If nothing is found, attribute "unit" unit.
                        $unityCategory = $em->getRepository('AppBundle:Unit')->findOneBySlug('unity');
                        $csvUsage->setUnit2($unityCategory);
                    }
                }


                $output->writeln('<comment>Added ' . $row[$name] . ' ---</comment>');

                $added++;
            } else {
                $dismissed++;
            }


            // Persist and flush
            $em->persist($csvUsage);
            $em->flush();


            // Each 20 users persisted we clear everything and show progress
            if (($i % $batchSize) === 0) {

                // Detaches all objects from Doctrine for memory save
                $em->clear();

                // Advancing for progress display on console
                $progress->advance($batchSize);

                $now = new \DateTime();
                $output->writeln(' of usages processed ... | ' . $now->format('d-m-Y G:i:s'));

            }

            $i++;

        }

        // Flushing and clear data on queue
        $em->flush();
        $em->clear();

        // Ending the progress bar process
        $progress->finish();

        // Outputs number of rows processed
        $output->writeln('');
        $output->writeln('<comment>Added ' . $added . ' | Dismissed ' . $dismissed . ' ---</comment>');
        $output->writeln('');
        $output->writeln('');
    }

    protected function get(InputInterface $input, OutputInterface $output)
    {
        // Getting the CSV from filesystem
        $fileName = $input->getArgument('path');

        // Using service for converting CSV to PHP Array
        $converter = $this->getContainer()->get('import.csvtoarray');
        $data = $converter->convert($fileName, ';');

        return $data;
    }


}