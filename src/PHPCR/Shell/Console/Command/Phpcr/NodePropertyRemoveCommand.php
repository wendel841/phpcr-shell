<?php

namespace PHPCR\Shell\Console\Command\Phpcr;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use PHPCR\PathNotFoundException;

class NodePropertyRemoveCommand extends BasePhpcrCommand
{
    protected function configure()
    {
        $this->setName('node:property:remove');
        $this->setDescription('Remove the property at the given absolute path');
        $this->addArgument('absPath', InputArgument::REQUIRED, 'Absolute path to property');
        $this->setHelp(<<<HERE
Remove the property from the current session at the given absolute path
HERE
        );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $session = $this->get('phpcr.session');
        $absPath = $input->getArgument('absPath');

        try {
            $property = $session->getProperty($absPath);
        } catch (PathNotFoundException $e) {
            throw new \Exception(sprintf(
                'Could not find a property at "%s"', $absPath
            ));
        }

        $property->remove();
    }
}
