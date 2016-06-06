<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Exception\UnsupportedDriverActionException;
use \Behat\MinkExtension\Context\RawMinkContext;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Behat\Mink\Driver\BrowserKitDriver;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;



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
     * @BeforeScenario @admin_fixtures
     */
    public function loadFixtures()
    {
        $loader = new ContainerAwareLoader($this->getContainer());
        $loader->loadFromDirectory(__DIR__.'/../../src/UserBundle/DataFixtures');
        $loader->loadFromDirectory(__DIR__.'/../../src/AppBundle/DataFixtures');
        $executor = new ORMExecutor($this->getEntityManager());
        $executor->execute($loader->getFixtures(), true);
    }

    /**
     * @Given there is a farmer with email :email and password :password
     */
    public function thereIsAFarmerWithEmailAndPassword($email, $password)
    {
        $user = new \UserBundle\Entity\User();
        $user->setFirstName("farmer_first_name");
        $user->setLastName("farmer_last_name");
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->setEnabled(true);

        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($user);
        $em->flush();

        return $user;
    }

    /**
     * @Given I am logged in as a farmer with email :email and password :password
     */
    public function iAmLoggedInAsAFarmer($email, $password)
    {
        $this->thereIsAFarmerWithEmailAndPassword($email,$password);
        $this->visitPath('/login');
        $this->getPage()->fillField('E-mail', $email);
        $this->getPage()->fillField('Mot de passe', $password);
        $this->getPage()->pressButton('Se connecter');
    }

    /**
     * @return \Behat\Mink\Element\DocumentElement
     */
    private function getPage()
    {
        return $this->getSession()->getPage();
    }


    /**
     * @return \Doctrine\ORM\EntityManager
     */
    private function getEntityManager()
    {
        return $this->getContainer()->get('doctrine.orm.entity_manager');
    }

    /**
     * @Given I am logged in as an admin with email :email and password :password
     */
    public function iAmLoggedInAsAnAdminWithEmailAndPassword($email, $password)
    {
        $this->visitPath('/login');
        $this->getPage()->fillField('E-mail', $email);
        $this->getPage()->fillField('Mot de passe', $password);
        $this->getPage()->pressButton('Se connecter');
    }


}
