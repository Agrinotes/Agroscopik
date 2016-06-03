<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use \Behat\MinkExtension\Context\RawMinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends RawMinkContext implements Context, SnippetAcceptingContext
{
    use \Behat\Symfony2Extension\Context\KernelDictionary;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @BeforeScenario
     */
    public function clearData()
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->createQuery('DELETE FROM UserBundle:User')->execute();
    }

    /**
     * @Given there is a farmer user with email :email and password :password
     */
    public function thereIsAFarmerUserWithEmailAndPassword($email, $password)
    {
        $user = new \UserBundle\Entity\User();
        $user->setFirstName("Jackie");
        $user->setLastName("Chan");
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->setRoles(array('ROLE_FARMER'));

        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($user);
        $em->flush();
    }
}
