<?php
/**
 * Results that must not be ignored.
 *
 * @package   SugarCommerce\SignedTokens
 * @copyright Copyright (c) 2026, ArrayPress Limited
 * @license   GPL-2.0-or-later
 */

declare( strict_types=1 );

namespace SugarCommerce\SignedTokens\Tests;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SugarCommerce\SignedTokens\TokenSigner;

/**
 * Class MustCheckTest
 *
 * These answer "did it work?" or "is it allowed?", and code that ignores the
 * answer behaves as though it were yes. #[\NoDiscard] makes PHP warn where a
 * result is dropped; this keeps the attribute from being lost in a refactor.
 */
final class MustCheckTest extends TestCase {

	/**
	 * @return array<string, array{string}>
	 */
	public static function methods(): array {
		return array_combine( array( 'verify', 'inspect', 'verify_detached' ), array_map( static fn ( string $m ): array => array( $m ), array( 'verify', 'inspect', 'verify_detached' ) ) );
	}

	#[DataProvider( 'methods' )]
	public function test_the_result_must_be_used( string $method ): void {
		$attributes = ( new \ReflectionMethod( TokenSigner::class, $method ) )->getAttributes( \NoDiscard::class );

		$this->assertCount( 1, $attributes, TokenSigner::class . '::' . $method . ' lost #[\NoDiscard].' );
		$this->assertNotSame( '', $attributes[0]->newInstance()->message, 'Say why it matters.' );
	}
}
