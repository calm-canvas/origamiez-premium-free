<?php
if ( php_sapi_name() !== 'cli' ) {
	die( 'This script can only be run from the command line.' );
}

error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

$test_dir = __DIR__;

require_once $test_dir . '/Sanitizers/SanitizerInterface.php';
require_once $test_dir . '/Sanitizers/CheckboxSanitizer.php';
require_once $test_dir . '/Sanitizers/TextSanitizer.php';
require_once $test_dir . '/Sanitizers/EmailSanitizer.php';
require_once $test_dir . '/Sanitizers/UrlSanitizer.php';
require_once $test_dir . '/Sanitizers/TextAreaSanitizer.php';
require_once $test_dir . '/Sanitizers/SelectSanitizer.php';
require_once $test_dir . '/SanitizationManager.php';

require_once $test_dir . '/Validators/ValidatorInterface.php';
require_once $test_dir . '/Validators/SearchQueryValidator.php';
require_once $test_dir . '/Validators/LoginAttemptTracker.php';

require_once $test_dir . '/SecurityHeaderManager.php';

use Origamiez\Engine\Security\Sanitizers\CheckboxSanitizer;
use Origamiez\Engine\Security\Sanitizers\SelectSanitizer;
use Origamiez\Engine\Security\SanitizationManager;
use Origamiez\Engine\Security\Validators\SearchQueryValidator;
use Origamiez\Engine\Security\SecurityHeaderManager;

$tests = 0;
$passed = 0;
$failed = 0;

function test( $name, $condition ) {
	global $tests, $passed, $failed;
	$tests++;
	if ( $condition ) {
		echo "✓ $name\n";
		$passed++;
	} else {
		echo "✗ $name\n";
		$failed++;
	}
}

echo "Running Security Classes Verification Tests\n";
echo "============================================\n\n";

echo "Testing Sanitizers (non-WordPress dependent):\n";
$checkbox_sanitizer = new CheckboxSanitizer();
test( 'CheckboxSanitizer converts true to true', true === $checkbox_sanitizer->sanitize( true ) );
test( 'CheckboxSanitizer converts false to false', false === $checkbox_sanitizer->sanitize( false ) );
test( 'CheckboxSanitizer converts 1 to true', true === $checkbox_sanitizer->sanitize( 1 ) );
test( 'CheckboxSanitizer converts null to false', false === $checkbox_sanitizer->sanitize( null ) );

$select_sanitizer = new SelectSanitizer( array( 'option1' => 'Option 1', 'option2' => 'Option 2' ), 'option1' );
test( 'SelectSanitizer has setChoices method', method_exists( $select_sanitizer, 'setChoices' ) );
test( 'SelectSanitizer has setDefault method', method_exists( $select_sanitizer, 'setDefault' ) );
test( 'SelectSanitizer is fluent', $select_sanitizer->setChoices( array() ) === $select_sanitizer );

echo "\nTesting SanitizationManager:\n";
$manager = SanitizationManager::getInstance();
test( 'SanitizationManager is singleton', $manager === SanitizationManager::getInstance() );
test( 'SanitizationManager has checkbox sanitizer', $manager->has( 'checkbox' ) );
test( 'SanitizationManager has text sanitizer', $manager->has( 'text' ) );
test( 'SanitizationManager has email sanitizer', $manager->has( 'email' ) );
test( 'SanitizationManager has url sanitizer', $manager->has( 'url' ) );
test( 'SanitizationManager has textarea sanitizer', $manager->has( 'textarea' ) );
test( 'SanitizationManager has select sanitizer', $manager->has( 'select' ) );
test( 'SanitizationManager has getSanitizer method', method_exists( $manager, 'getSanitizer' ) );
test( 'SanitizationManager has sanitizeCheckbox method', method_exists( $manager, 'sanitizeCheckbox' ) );
test( 'SanitizationManager has sanitizeText method', method_exists( $manager, 'sanitizeText' ) );
test( 'SanitizationManager has sanitizeEmail method', method_exists( $manager, 'sanitizeEmail' ) );
test( 'SanitizationManager has sanitizeUrl method', method_exists( $manager, 'sanitizeUrl' ) );
test( 'SanitizationManager has sanitizeTextarea method', method_exists( $manager, 'sanitizeTextarea' ) );
test( 'SanitizationManager has sanitizeSelect method', method_exists( $manager, 'sanitizeSelect' ) );

echo "\nTesting Validators (non-WordPress dependent):\n";
$search_validator = new SearchQueryValidator( 100, 1 );
test( 'SearchQueryValidator has setMaxLength method', method_exists( $search_validator, 'setMaxLength' ) );
test( 'SearchQueryValidator has setMinLength method', method_exists( $search_validator, 'setMinLength' ) );
test( 'SearchQueryValidator has isValid method', method_exists( $search_validator, 'isValid' ) );
test( 'SearchQueryValidator has sanitizeQuery method', method_exists( $search_validator, 'sanitizeQuery' ) );
test( 'SearchQueryValidator is fluent', $search_validator->setMaxLength( 50 ) === $search_validator );

echo "\nTesting SecurityHeaderManager:\n";
$header_manager = new SecurityHeaderManager();
test( 'SecurityHeaderManager has X-Content-Type-Options header', null !== $header_manager->getHeader( 'X-Content-Type-Options' ) );
test( 'SecurityHeaderManager has X-Frame-Options header', null !== $header_manager->getHeader( 'X-Frame-Options' ) );
test( 'SecurityHeaderManager has X-XSS-Protection header', null !== $header_manager->getHeader( 'X-XSS-Protection' ) );
test( 'SecurityHeaderManager has Referrer-Policy header', null !== $header_manager->getHeader( 'Referrer-Policy' ) );
test( 'SecurityHeaderManager has CSP config', ! empty( $header_manager->getCSPConfig() ) );
test( 'SecurityHeaderManager can build CSP string', ! empty( $header_manager->getCSP() ) );
test( 'SecurityHeaderManager has getAllHeaders method', method_exists( $header_manager, 'getAllHeaders' ) );
test( 'SecurityHeaderManager has setHeader method', method_exists( $header_manager, 'setHeader' ) );
test( 'SecurityHeaderManager has removeHeader method', method_exists( $header_manager, 'removeHeader' ) );
test( 'SecurityHeaderManager has setCSPDirective method', method_exists( $header_manager, 'setCSPDirective' ) );
test( 'SecurityHeaderManager has removeCSPDirective method', method_exists( $header_manager, 'removeCSPDirective' ) );
test( 'SecurityHeaderManager has disableCSP method', method_exists( $header_manager, 'disableCSP' ) );
test( 'SecurityHeaderManager has sendHeaders method', method_exists( $header_manager, 'sendHeaders' ) );
test( 'SecurityHeaderManager has register method', method_exists( $header_manager, 'register' ) );
test( 'SecurityHeaderManager is fluent (setHeader)', $header_manager->setHeader( 'Test', 'value' ) === $header_manager );
test( 'SecurityHeaderManager is fluent (removeHeader)', $header_manager->removeHeader( 'Test' ) === $header_manager );

echo "\nTesting Interface Implementation:\n";
test( 'CheckboxSanitizer implements SanitizerInterface', $checkbox_sanitizer instanceof \Origamiez\Engine\Security\Sanitizers\SanitizerInterface );
test( 'SelectSanitizer implements SanitizerInterface', $select_sanitizer instanceof \Origamiez\Engine\Security\Sanitizers\SanitizerInterface );
test( 'SearchQueryValidator implements ValidatorInterface', $search_validator instanceof \Origamiez\Engine\Security\Validators\ValidatorInterface );

echo "\n============================================\n";
echo "Results: $passed/$tests tests passed\n";

if ( $failed > 0 ) {
	echo "Failed: $failed\n";
	exit( 1 );
}

exit( 0 );
