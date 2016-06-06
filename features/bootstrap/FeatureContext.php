<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use \Behat\MinkExtension\Context\RawMinkContext;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;


/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawMinkContext implements Context, SnippetAcceptingContext
{
    use \Behat\Symfony2Extension\Context\KernelDictionary;

    public function __construct()
    {
    }

    private $currentUser;

    /**
     * @BeforeScenario
     */
    public function clearData()
    {
        $purger = new ORMPurger($this->getContainer()->get('doctrine')->getManager());
        $purger->purge();
    }

    /**
     * @Given there is a farmer user with email :email and password :password
     */
    public function thereIsAFarmerUserWithEmailAndPassword($email, $password)
    {
        $user = new \UserBundle\Entity\User();
        $user->setFirstName("Hugo");
        $user->setLastName("Lehoux");
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->setEnabled(true);
        $user->addRole('ROLE_FARMER');

        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($user);
        $em->flush();

        return $user;
    }

    /**
     * @Given I am logged in as a farmer
     */
    public function iAmLoggedInAsAFarmer()
    {
        $this->currentUser = $this->thereIsAFarmerUserWithEmailAndPassword('admin', 'admin');
    }


}
