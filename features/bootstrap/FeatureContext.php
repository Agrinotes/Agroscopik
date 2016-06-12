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
     * @BeforeScenario @clear_data
     */
    public function clearData()
    {
        $purger = new ORMPurger($this->getContainer()->get('doctrine')->getManager());
        $purger->purge();
    }

    /**
     * @BeforeScenario @load_admin_fixtures
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
     * @BeforeScenario @loadInterventions
     */
    public function loadInterventions()
    {
        $loader = new ContainerAwareLoader($this->getContainer());
        $loader->loadFromFile(__DIR__.'/../../src/AppBundle/DataFixtures/ORM/LoadInterventionCategories.php');
        $loader->loadFromFile(__DIR__.'/../../src/AppBundle/DataFixtures/ORM/LoadInterventions.php');
        $executor = new ORMExecutor($this->getEntityManager());
        $executor->execute($loader->getFixtures(), true);
    }

    /**
     * @Given there is a user with email :email and password :password
     */
    public function thereIsAUserWithEmailAndPassword($email, $password)
    {
        $this->visitPath('/register');
        $this->getPage()->fillField('Prénom', "farmer_first_name");
        $this->getPage()->fillField('Nom', "farmer_last_name");
        $this->getPage()->fillField('E-mail', $email);
        $this->getPage()->fillField('Mot de passe', $password);
        $this->getPage()->pressButton('Créer un compte');
        $this->visitPath('/logout');
    }

    /**
     * @Given I am logged in with email :email and password :password
     */
    public function iAmLoggedInWithAndPassword($email, $password)
    {
        $this->thereIsAUserWithEmailAndPassword($email,$password);
        $this->visitPath('/login');
        $this->getPage()->fillField('E-mail', $email);
        $this->getPage()->fillField('Mot de passe', $password);
        $this->getPage()->pressButton('Se connecter');
    }

    /**
     * @Given there is a farmer with email :email and password :password
     */
    public function thereIsAFarmerWithEmailAndPassword($email, $password)
    {
        $this->thereIsAUserWithEmailAndPassword($email, $password);
        $this->iAmLoggedInWithAndPassword($email, $password);
        $this->visitPath('/farm/new'); // I should be able to remove that one
        $this->getPage()->fillField('Nom', "Farm 1");
        $this->getPage()->pressButton('Enregistrer');
        $this->visitPath('logout');
    }

    /**
     * @Given I am logged in as a farmer with email :email and password :password
     */
    public function iAmLoggedInAsAFarmerWithEmailAndPassword($email, $password)
    {
        $this->thereIsAFarmerWithEmailAndPassword($email,$password);
        $this->iAmLoggedInWithAndPassword($email,$password);
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
        // I should be able to create the admin right here...
        $this->visitPath('/login');
        $this->getPage()->fillField('E-mail', $email);
        $this->getPage()->fillField('Mot de passe', $password);
        $this->getPage()->pressButton('Se connecter');
    }

    /**
     * @Given I have a plot :plot
     */
    public function iHaveAPlot($plot)
    {
        $this->visitPath('/plot/new');
        $this->getPage()->fillField('Nom', $plot);
        $this->getPage()->pressButton('Enregistrer');
    }

    /**
     * @Given I have a crop cycle :cropcycle on plot :plot
     */
    public function iHaveACropCycleOnPlot($cropcycle, $plot)
    {
        $this->iHaveAPlot($plot);
        $this->getPage()->clickLink("Ajouter une culture");
        $this->getPage()->fillField('Nom', $cropcycle);
        $this->getPage()->pressButton('Enregistrer');
    }


}
