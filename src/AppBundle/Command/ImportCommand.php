<?php

namespace AppBundle\Command;

use AppBundle\Entity\Speciality;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
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
            ->addArgument('path', InputArgument::REQUIRED, 'The path to the csv file.')
        ;
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

        // Getting doctrine manager
        $em = $this->getContainer()->get('doctrine')->getManager();
        // Turning off doctrine default logs queries for saving memory
        $em->getConnection()->getConfiguration()->setSQLLogger(null);

        // Define the size of record, the frequency for persisting the data and the current index of records
        $size = count($data);

        $batchSize = 20;
        $i = 1;
        $added = 0;
        $dismissed = 0;

        // Starting progress
        $progress = new ProgressBar($output, $size);
        $progress->start();

        // Processing on each row of data
        foreach($data as $row) {

            $speciality = $em->getRepository('AppBundle:Speciality')
                ->findOneByAmm(intval($row[2]));

            // If the pesticide doest not exist we create one
            if(!is_object($speciality)){

                // Creates a speciality
                $newSpeciality = new Speciality();

                // Give basic attributes
                $newSpeciality->setAmm(intval($row[2]));
                $newSpeciality->setName($row[3]);
                $newSpeciality->setAlternativeName($row[4]);
                $newSpeciality->setOwner($row[5]);
                $newSpeciality->setAuthorizedMentions($row[8]);
                $newSpeciality->setComposition($row[9]);

                // Guess unit category from usage unit
                $csvUnit = explode("/", $row(16), 2)[0];
                $unit = $em->getRepository('AppBundle:Unit')->findOneBySymbol($csvUnit);
                if(is_object($unit)){
                    $newSpeciality->setUnitCategory($unit->getUnitCategory());
                }else{
                    // En cours
                }

                $em->persist($newSpeciality);
                $em->flush();

                $output->writeln('<comment>Added ' . $row[3] . ' ---</comment>');

                $added++;

            }else{
                $dismissed++;
            }

            // Each 20 users persisted we flush everything
            if (($i % $batchSize) === 0) {

                $em->flush();
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
        $output->writeln('');
        $output->writeln('<comment>Added ' . $added .' | Dismissed '.$dismissed.' ---</comment>');

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