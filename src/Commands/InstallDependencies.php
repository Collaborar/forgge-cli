<?php

namespace Forgge\Cli\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Forgge\Cli\NodePackageManagers\Proxy;
use Forgge\Cli\Presets\FilesystemTrait;

class InstallDependencies extends Command {
	use FilesystemTrait;

	/**
	 * {@inheritDoc}
	 */
	protected function configure() {
		$this
			->setName( 'install:dependencies' )
			->setDescription( 'Install Node dependencies.' )
			->setHelp( 'Installs all required Node dependencies.' );
	}

	/**
	 * {@inheritDoc}
	 */
	protected function execute( InputInterface $input, OutputInterface $output ) {
		$package_manager = new Proxy();

		$package_manager->installAll( getcwd(), $output );

		return 0;
	}
}
