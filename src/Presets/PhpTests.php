<?php

namespace Forgge\Cli\Presets;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\RuntimeException;
use Forgge\Cli\Composer\Composer;

class PhpTests implements PresetInterface {
	use FilesystemTrait;

	/**
	 * Package name.
	 *
	 * @var string
	 */
	protected $package_name = 'pestphp/pest';

	/**
	 * Version constraint.
	 *
	 * @var string|null
	 */
	protected $version_constraint = null;

	/**
	 * Constructor.
	 *
	 * @param string $version_constraint
	 */
	public function __construct( $version_constraint ) {
		$this->version_constraint = $version_constraint;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getName() {
		return 'PHP Tests';
	}

	/**
	 * {@inheritDoc}
	 */
	public function execute( $directory, OutputInterface $output ) {
		if ( Composer::installed( $directory, $this->package_name ) ) {
			throw new RuntimeException( 'The Pest composer package is already installed.' );
		}

		Composer::install( $directory, $this->package_name, $this->version_constraint, true );

		$directories = [
			$this->path( $directory, 'tests' ),
			$this->path( $directory, 'tests', 'php' ),
			$this->path( $directory, 'tests', 'php', 'unit-tests' ),
		];

		foreach ( $directories as $dir ) {
			if ( ! file_exists( $dir ) ) {
				mkdir( $dir );
			}
		}

		$copy_list = $this->getCopyList( $directory );
		$failures = $this->copy( $copy_list );

		foreach ( $failures as $source => $destination ) {
			$output->writeln( '<failure>File ' . $destination . ' already exists - skipped.</failure>' );
		}
	}

	/**
	 * Get array of files to copy.
	 *
	 * @param  string $directory
	 * @return array
	 */
	protected function getCopyList( $directory ) {
		$copy_list = [
			$this->path( FORGGE_CLI_DIR, 'src', 'PhpTests', 'tests', 'php', 'unit-tests', 'ExampleTest.php' )
				=> $this->path( $directory, 'tests', 'php', 'unit-tests', 'ExampleTest.php' ),

			$this->path( FORGGE_CLI_DIR, 'src', 'PhpTests', 'tests', 'php', 'bootstrap.php' )
				=> $this->path( $directory, 'tests', 'php', 'bootstrap.php' ),

			$this->path( FORGGE_CLI_DIR, 'src', 'PhpTests', 'tests', 'php', 'README.md' )
				=> $this->path( $directory, 'tests', 'php', 'README.md' ),

			$this->path( FORGGE_CLI_DIR, 'src', 'PhpTests', 'phpunit.xml' )
				=> $this->path( $directory, 'phpunit.xml' ),
		];

		return $copy_list;
	}
}
