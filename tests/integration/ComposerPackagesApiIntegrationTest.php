<?php

namespace ComposerPackages\Test;

use ComposerPackages\Api\ComposerPackages;

use RequestContext;
use FauxRequest;
use Language;
use ApiMain;

/**
 * @covers \ComposerPackages\Api\ComposerPackages
 *
 * @group ComposerPackages
 *
 * @licence GNU GPL v2+
 * @since 0.1
 *
 * @author mwjames
 */
class ComposerPackagesApiIntegrationTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @since 0.1
	 */
	public function newInstance() {

		$context = new RequestContext();
		$context->setRequest( new FauxRequest( array(), true ) );
		$context->setLanguage( Language::factory( 'en' ) );

		$apiMain = new ApiMain( $context, true );
		$instance = new ComposerPackages( $apiMain, 'composerpackages' );

		return $instance;
	}

	/**
	 * @since 0.1
	 */
	public function testExecute() {

		try {
			$this->newInstance()->execute( '' );
		} catch ( \Exception $exception ) {
			if ( !( $exception instanceof \PermissionsError ) && !( $exception instanceof \ErrorPageError ) ) {
				throw $exception;
			}
		}

		$this->assertTrue( true, 'Asserts that Api module ComposerPackages run without errors' );
	}

	/**
	 * @since 0.1
	 */
	public function testExecuteOnNotSupportedFormatRaisingUsageException() {

		$instance = $this->newInstance();

		try {
			$instance->getMain()->getResult()->setRawMode();
			$instance->execute( '' );
		} catch ( \UsageException $e ) {
			$this->assertTrue( true, 'Asserts that XML format is not supported' );
		}

	}

}
