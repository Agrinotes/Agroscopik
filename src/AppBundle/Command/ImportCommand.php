<?php

namespace AppBundle\Command;

use AppBundle\Entity\Speciality;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;

class ImportCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        // Name and description for app/console command
        $this
            ->setName('update:pesticides')
            ->setDescription('Update pesticides from CSV file')
            ->addArgument('path', InputArgument::OPTIONAL, 'The path to the csv file.','web/uploads/import/pesticides.csv')
            ->addOption(
                'download-url',
                null,
                InputOption::VALUE_REQUIRED,
                'Set download path',
                'https://www.data.gouv.fr/s/resources/donnees-ouvertes-du-catalogue-des-produits-phytopharmaceutiques-adjuvants-matieres-fertilisantes-et-support-de-culture-produits-mixtes-et-melanges-e-phy/20161230-162255/usages_des_produits_autorises_v2_utf8-29122016.csv'
            )
            ->addOption(
                'no-download',
                null,
                InputOption::VALUE_NONE,
                ''
            )
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
                'Set name column number',
                3
            )
            ->addOption(
                'alt-name',
                null,
                InputOption::VALUE_REQUIRED,
                'Set alternative name column number',
                4
            )
            ->addOption(
                'no-alt-name',
                null,
                InputOption::VALUE_NONE,
                'Use if no alternative name in csv file'
            )
            ->addOption(
                'owner',
                null,
                InputOption::VALUE_REQUIRED,
                'Set owner column number',
                5
            )
            ->addOption(
                'no-owner',
                null,
                InputOption::VALUE_NONE,
                'Use if no owner in csv file'
            )
            ->addOption(
                'authorized-mentions',
                null,
                InputOption::VALUE_REQUIRED,
                'Set authorized mentions and comments column number',
                8
            )
            ->addOption(
                'no-authorized-mentions',
                null,
                InputOption::VALUE_NONE,
                'Use if no authorized mentions in csv file'
            )
            ->addOption(
                'composition',
                null,
                InputOption::VALUE_REQUIRED,
                'Set composition column number',
                9
            )
            ->addOption(
                'no-composition',
                null,
                InputOption::VALUE_NONE,
                'Use if no composition in csv file'
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
        $name = $input->getOption('name');
        $alternativeName = $input->getOption('no-alt-name') ? false : $input->getOption('alt-name');
        $owner = $input->getOption('no-owner') ? false : $input->getOption('owner');
        $authorizedMentions = $input->getOption('no-authorized-mentions') ? false : $input->getOption('authorized-mentions');
        $composition = $input->getOption('no-composition') ? false : $input->getOption('composition');
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
        $updated = 0;

        // Starting progress
        $progress = new ProgressBar($output, $size);
        $progress->start();

        // Processing on each row of data
        foreach ($data as $row) {

            $speciality = $em->getRepository('AppBundle:Speciality')
                ->findOneByAmm(intval($row[$amm]));

            // If the pesticide doest not exist we create one
            if (!is_object($speciality)) {

                // Creates a speciality
                $speciality = new Speciality();

                // Give basic attributes
                $speciality->setAmm(intval($row[$amm]));

                $output->writeln('<comment>Added ' . $row[3] . ' ---</comment>');

                $added++;
            } else {
                $updated++;
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
        $output->writeln('<comment>Added ' . $added . ' | Updated ' . $updated . ' ---</comment>');
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
        // Down load file from the web
        if(!$input->getOption('no-download')){
            // This is the entire file that was uploaded to a temp location.
            $fp = fopen('web/uploads/import/pesticides.csv', 'w');

// Connecting to website.
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $input->getOption('download-url'));
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
            curl_exec ($ch);

            if (curl_errno($ch)) {
                $msg = curl_error($ch);
            }
            else {

                $msg = 'File uploaded successfully from '.$input->getOption('download-url');
            }

            curl_close ($ch);

            fclose($fp);


            echo $msg;
        }

        // Getting the CSV from filesystem
        $fileName = $input->getArgument('path');

        // Using service for converting CSV to PHP Array
        $converter = $this->getContainer()->get('import.csvtoarray');
        $data = $converter->convert($fileName, ';');

        return $data;
    }



}