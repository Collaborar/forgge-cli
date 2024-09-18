<?php

namespace MyApp\Tests;

/**
 * Set up a new app instance to use for tests.
 */
beforeEach( function () {
	// Set up an app instance with whatever stubs and mocks we need before every test.
	\MyApp::make()->bootstrap( [], false );

	// Since we don't want to test Forgge internals, we can overwrite them during testing:
	// \MyApp::alias( 'view', function ( $view ) { return $view; } );

	// or we can replace the entire app instance:
	// \MyApp::setApplication( new MyMockApplication() );
} );

/**
 * Tear down our test app instance.
 */
afterEach( function () {
	\MyApp::setApplication( null );
} );

/**
 * Test.
 */
describe( 'ExampleTest', function () {
	it( 'test foo', function () {
		$this->assertTrue( true );
	} );
} );
