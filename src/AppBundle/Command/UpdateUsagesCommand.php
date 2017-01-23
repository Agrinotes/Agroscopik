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
            ->addArgument('path', InputArgument::OPTIONAL, 'The path to the csv file.','web/uploads/import/pesticides.csv')
            ->addOption(
                'amm',
                null,
                InputOption::VALUE_REQUIRED,
                'Set AMM (Autorisation Mise sur le marché) column number',
                2
            )
            ->addOption(
                'usage-unit',
                null,
                InputOption::VALUE_REQUIRED,
                'Set usage unit column number',
                17
            )
            ->addOption(
                'no-usage-unit',
                null,
                InputOption::VALUE_NONE,
                'Use if no unit in csv file'
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


        $usage_unit = $input->getOption('no-usage-unit') ? false : $input->getOption('usage-unit');

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
                $csvUsage->setShortNumber();
                $csvUsage->setName();
                $csvUsage->setMinCropStage();
                $csvUsage->setMaxCropStage();
                $csvUsage->setStatus();
                $csvUsage->setDose();
                $csvUsage->setAmountUnit2();
                $csvUsage->setFullUnit();
                $csvUsage->setDAR();
                $csvUsage->setMaxActions();
                $csvUsage->setConditions();
                $csvUsage->setZNTwater();
                $csvUsage->setZNTarthropodes();
                $csvUsage->setZNTplants();
                // Guess unit category
                $csvUsage->setUnit1();
                $csvUsage->setUnit2();






                $output->writeln('<comment>Added ' . $row[3] . ' ---</comment>');

                $added++;
            } else {
                $dismissed++;
            }

            // Give or Update basic attributes
            $speciality->setName($row[$name]);

            if ($alternativeName) {
                $speciality->setAlternativeName($row[$alternativeName]);
            }

            if ($owner) {
                $speciality->setOwner($row[$owner]);
            }
            if ($authorizedMentions) {
                $speciality->setAuthorizedMentions($row[$authorizedMentions]);
            }
            if ($composition) {
                $speciality->setComposition($row[$composition]);
            }

            if ($usage_unit) {
                // Guess unit category from usage unit
                $csvUnit = strtok($row[$usage_unit], '/');
                $unit = $em->getRepository('AppBundle:Unit')->findOneBySymbol($csvUnit);

                if (is_object($unit)) {
                    // If unit exists, attribute its category to this pesticide
                    $speciality->setUnitCategory($unit->getUnitCategory());
                } else {
                    // If nothing is found, attribute none category that has a "unit" unit.
                    $noneCategory = $em->getRepository('AppBundle:UnitCategory')->findOneBySlug('none');
                    $speciality->setUnitCategory($noneCategory);
                }
            }

            // Persist and flush
            $em->persist($speciality);
            $em->flush();


            // Each 20 users persisted we clear everything and show progress
            if (($i % $batchSize) === 0) {

                // Detaches all objects from Doctrine for memory save
                $em->clear();

                // Advancing for progress display on console
                $progress->advance($batchSize);

                $now = new \DateTime();
                $output->writeln(' of pesticides processed ... | ' . $now->format('d-m-Y G:i:s'));

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
        if (!$alternativeName) {
            $output->writeln('<comment>No alternative name updated ---</comment>');
        };
        if (!$owner) {
            $output->writeln('<comment>No owning company updated ---</comment>');
        };
        if (!$authorizedMentions) {
            $output->writeln('<comment>No authorized mention updated ---</comment>');
        };
        if (!$composition) {
            $output->writeln('<comment>No composition updated ---</comment>');
        };
        if (!$usage_unit) {
            $output->writeln('<comment>No unit category updated ---</comment>');
        };
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