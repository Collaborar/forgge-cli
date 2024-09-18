<?php

namespace Forgge\Cli\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Forgge\Cli\Presets\PhpTests;

class InstallPhpTests extends Command {
	/**
	 * {@inheritDoc}
	 */
	protected function configure() {
		$this
			->setName( 'install:php-tests' )
			->setDescription( 'Install pest testing environment.' )
			->setHelp( 'Install pest testing environment.' )
			->addArgument(
				'version',
				InputArgument::OPTIONAL,
				'Version constraint.'
			);
	}

	/**
	 * {@inheritDoc}
	 */
	protected function execute( InputInterface $input, OutputInterface $output ) {
		$version = $input->getArgument( 'version' );

		$preset = new PhpTests( $version );
		$preset->execute( getcwd(), $output );

		return 0;
	}
}
