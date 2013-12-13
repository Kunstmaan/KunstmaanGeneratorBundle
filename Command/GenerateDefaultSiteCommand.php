<?php

namespace Kunstmaan\GeneratorBundle\Command;

use Kunstmaan\GeneratorBundle\Generator\DefaultSiteGenerator;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputOption;

/**
 * Generates a default website based on Kunstmaan bundles
 */
class GenerateDefaultSiteCommand extends KunstmaanGenerateCommand
{
    /**
     * @var BundleInterface
     */
    private $bundle;

    /**
     * @var string
     */
    private $prefix;

    /**
     * @var bool
     */
    private $demosite;

    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setHelp(<<<EOT
The <info>kuma:generate:site</info> command generates an website using the Kunstmaan bundles

<info>php app/console kuma:generate:default-site --namespace=Namespace/NamedBundle</info>

Use the <info>--prefix</info> option to add a prefix to the table names of the generated entities

<info>php app/console kuma:generate:default-site --namespace=Namespace/NamedBundle --prefix=demo_</info>
EOT
            )
            ->setDescription('Generates a basic website based on Kunstmaan bundles with default templates')
            ->addOption('namespace', '', InputOption::VALUE_OPTIONAL, 'The namespace to generate the default website in')
            ->addOption('prefix', '', InputOption::VALUE_OPTIONAL, 'The prefix to be used in the table names of the generated entities')
            ->addOption('demosite', '', InputOption::VALUE_NONE, 'Whether to generate a website with demo contents or a basic website')
            ->setName('kuma:generate:default-site');
    }

    /**
     * {@inheritdoc}
     */
    protected function getWelcomeText()
    {
        return 'Welcome to the Kunstmaan default site generator';
    }

    /**
     * {@inheritdoc}
     */
    protected function doExecute()
    {
        $this->assistant->writeSection('Site generation');

        $this->assistant->writeLine(array("This command helps you to generate a default site setup.\n"));

        /**
         * Ask for which bundle we need to create the layout
         */
        $bundleNamespace = $this->assistant->getOptionOrDefault('namespace', null);
        $this->bundle = $this->askForBundleName('layout', $bundleNamespace);

        /**
         * Ask the database table prefix
         */
        $bundlePrefix = $this->assistant->getOptionOrDefault('prefix', $this->bundle->getNamespace());
        $this->prefix = $this->askForPrefix(null, $bundlePrefix);

        /**
         * If we need to generate a full site, or only the basic structure
         */
        $this->demosite = $this->assistant->getOption('demosite');

        // First we generate the layout if it is not yet generated
        if (!is_file($this->bundle->getPath().'/Resources/views/Layout/layout.html.twig')) {
            $command = $this->getApplication()->find('kuma:generate:layout');
            $arguments = array(
                'command'      => 'kuma:generate:layout',
                '--namespace'  => str_replace('\\', '/', $this->bundle->getNamespace()),
                '--subcommand' => true
            );
            $input = new ArrayInput($arguments);
            $command->run($input, $this->assistant->getOutput());
        }

        $rootDir = $this->getApplication()->getKernel()->getRootDir().'/../';
        $this->createGenerator()->generate($this->bundle, $this->prefix, $rootDir, $this->demosite);

        $this->assistant->writeSection('Site successfully created', 'bg=green;fg=black');
        $this->assistant->writeLine(array(
            'Make sure you update your database first before using the created entities:',
            '    Directly update your database:          <comment>app/console doctrine:schema:update --force</comment>',
            '    Create a Doctrine migration and run it: <comment>app/console doctrine:migrations:diff && app/console doctrine:migrations:migrate</comment>',
            '    New DataFixtures were created. You can load them via: <comment>app/console doctrine:fixtures:load --fixtures=src/'.str_replace('\\', '/', $this->bundle->getNamespace()).'/DataFixtures/ORM/DefaultSiteGenerator/ --append</comment>',
            ''
        ));
    }

    /**
     * Get the generator.
     *
     * @return DefaultSiteGenerator
     */
    protected function createGenerator()
    {
        $filesystem = $this->getContainer()->get('filesystem');
        $registry = $this->getContainer()->get('doctrine');

        return new DefaultSiteGenerator($filesystem, $registry, '/defaultsite', $this->assistant);
    }
}
