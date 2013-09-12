<?php

namespace {{ namespace }}\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

use Faker\Provider\Lorem;
use Faker\Provider\DateTime;

use Kunstmaan\UtilitiesBundle\Helper\Slugifier;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use {{ namespace }}\Entity\Pages\Search\SearchPage;

/**
 * SearchFixtures
 */
class SearchFixtures extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container = null;

    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        if ($this->container->getParameter('multilanguage')) {
            $languages = explode('|', $this->container->getParameter('requiredlocales'));
        }
        if (!is_array($languages) || count($languages) < 1) {
            $languages = array('en');
        }

        $em = $this->container->get('doctrine.orm.entity_manager');

        $pageCreator = $this->container->get('kunstmaan_node.page_creator_service');

        // Create article overview page
        $nodeRepo = $em->getRepository('KunstmaanNodeBundle:Node');
        $homePage = $nodeRepo->findOneBy(array('internalName' => 'homepage'));

        $searchPage = new SearchPage();
        $searchPage->setTitle('Search');

        $translations = array();
        foreach ($languages as $lang) {
            if ($lang == 'nl') {
                $title = 'Zoeken';
            } else {
                $title = 'Search';
            }

            $translations[] = array('language' => $lang, 'callback' => function($page, $translation, $seo) use($title) {
                $translation->setTitle($title);
                $translation->setSlug(Slugifier::slugify($title));
                $translation->setWeight(50);
            });
        }

        $options = array(
            'parent' => $homePage,
            'page_internal_name' => 'search',
            'set_online' => true,
            'creator' => 'Admin'
        );

        $pageCreator->createPage($searchPage, $translations, $options);
    }

    /**
     * Get the order of this fixture
     *
     * @return int
     */
    public function getOrder()
    {
        return 70;
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface $container A ContainerInterface instance
     *
     * @api
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

}
