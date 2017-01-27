<?php

namespace AppBundle\Command;

use AppBundle\Entity\Action;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;

class ActionsCleanCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        // Name and description for app/console command
        $this
            ->setName('clean:actions')
            ->setDescription('Removes unnecessary fields for every action');

    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {

        // Showing when the script is launched
        $start = new \DateTime();

        // Importing CSV on DB via Doctrine ORM
        $this->clean($input, $output);

        // Showing when the script is over
        $end = new \DateTime();

        $output->writeln('<comment>Start : ' . $start->format('d-m-Y G:i:s') . ' ---</comment>');
        $output->writeln('<comment>End : ' . $end->format('d-m-Y G:i:s') . ' ---</comment>');
    }

    protected function clean(InputInterface $input, OutputInterface $output)
    {

        // Getting doctrine manager
        $em = $this->getContainer()->get('doctrine')->getManager();
        // Turning off doctrine default logs queries for saving memory
        $em->getConnection()->getConfiguration()->setSQLLogger(null);


        $limit = 100;
        $offset = 0;
        $cleaned = 0;

        while ($actions = $em->getRepository('AppBundle:Action')->findBy(array(), array(), $limit, $offset)) {
            foreach ($actions as $action) {

                if ($action->getIntervention()->getInterventionCategory()->getSlug() != "protection-des-cultures") {
                    foreach ($action->getFarmSpecialityMvts() as $mvt) {
                        $em->remove($mvt);
                    };
                }

                if ($action->getIntervention()->getInterventionCategory()->getSlug() != "fertilisation") {
                    foreach ($action->getFarmFertilizerMvts() as $mvt) {
                        $em->remove($mvt);
                    };
                }

                // Remove harvest products added to wrong categories
                if ($action->getIntervention()->getInterventionCategory()->getSlug() != 'recolte') {
                    foreach ($action->getHarvestProducts() as $product) {
                        $em->remove($product);
                    }
                }

                // Remove seeds or plant density products added to wrong categories
                if ($action->getIntervention()->getInterventionCategory()->getSlug() != 'semis-et-plantation') {
                    $action->setDensity(null);
                    $action->setDensityUnit(null);
                }

                // Remove pH and EC added to wrong categories
                if ($action->getIntervention()->getName() != 'Relevé pH/EC') {
                    $action->setPH(null);
                    $action->setEc(null);
                }

                // Remove irrigations added to wrong categories
                if ($action->getIntervention()->getInterventionCategory()->getSlug() != 'irrigation') {
                    foreach ($action->getIrrigations() as $i) {
                        $em->remove($i);
                    }
                }

                // Remove tank volume added to wrong intervention
                if ($action->getIntervention()->getName() != 'Préparation d\'une cuve de solution-mère') {
                    $action->setTankVolume(null);
                    $em->flush();
                }

                // Remove drainage added to wrong intervention
                if ($action->getIntervention()->getName() != 'Relevé de drainage') {
                    $action->setDrainage(null);
                    $em->flush();
                }


                $em->flush();
                $em->clear();
            }

            $offset += $limit;
            $cleaned += $limit;

            $output->writeln('<comment>Cleaned ' . $cleaned . ' actions ---</comment>');

        }
    }
}