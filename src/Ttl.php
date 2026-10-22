<?php
/**
 * Readable token lifetimes.
 *
 * @package   SugarCommerce\SignedTokens
 * @copyright Copyright (c) 2026, ArrayPress Limited
 * @license   GPL-2.0-or-later
 * @since     1.0.0
 */

declare( strict_types=1 );

namespace SugarCommerce\SignedTokens;

/**
 * Class Ttl
 *
 * `$signer->sign( 'magic-link', $claims, 900 )` is a unit bug waiting to
 * happen — 900 what? `Ttl::FIFTEEN_MINUTES` cannot be misread, and
 * `Ttl::hours( 2 )` cannot be miscalculated.
 *
 * Constants for the common cases, factories for everything else. All
 * values are plain integer seconds, so they pass straight to
 * {@see TokenSigner::sign()} with no conversion.
 *
 * **Choosing one.** A stateless token cannot be revoked, so its lifetime
 * *is* its blast radius: anyone who obtains it — from a forwarded email,
 * a shared screen, a proxy log, a browser history — can use it until it
 * expires. Pick the shortest span that still works for the user:
 *
 *   | Purpose                | Suggested            |
 *   |------------------------|----------------------|
 *   | Password reset         | {@see self::FIFTEEN_MINUTES} |
 *   | Magic sign-in          | {@see self::FIFTEEN_MINUTES} |
 *   | Email verification     | {@see self::DAY}     |
 *   | Signed download URL    | {@see self::HOUR}    |
 *   | Abandoned-cart resume  | {@see self::WEEK}    |
 *   | Unsubscribe link       | {@see self::YEAR}    |
 *
 * The long ones are defensible because the damage is bounded: an
 * unsubscribe link only unsubscribes. Nothing that grants a session
 * should outlive an hour.
 *
 * @since 1.0.0
 */
final readonly class Ttl {

	/**
	 * One minute.
	 */
	public const int MINUTE = 60;

	/**
	 * Five minutes.
	 */
	public const int FIVE_MINUTES = 300;

	/**
	 * Ten minutes.
	 */
	public const int TEN_MINUTES = 600;

	/**
	 * Fifteen minutes. Password resets and magic sign-in links.
	 */
	public const int FIFTEEN_MINUTES = 900;

	/**
	 * Thirty minutes.
	 */
	public const int THIRTY_MINUTES = 1800;

	/**
	 * One hour. Signed download URLs.
	 */
	public const int HOUR = 3600;

	/**
	 * Two hours.
	 */
	public const int TWO_HOURS = 7200;

	/**
	 * Six hours.
	 */
	public const int SIX_HOURS = 21600;

	/**
	 * Twelve hours.
	 */
	public const int TWELVE_HOURS = 43200;

	/**
	 * One day. Email verification.
	 */
	public const int DAY = 86400;

	/**
	 * Three days.
	 */
	public const int THREE_DAYS = 259200;

	/**
	 * One week. Abandoned-cart resume links.
	 */
	public const int WEEK = 604800;

	/**
	 * Thirty days.
	 */
	public const int THIRTY_DAYS = 2592000;

	/**
	 * 365 days. Unsubscribe links, and nothing that grants access.
	 */
	public const int YEAR = 31536000;

	/**
	 * N minutes in seconds.
	 *
	 * @since 1.0.0
	 *
	 * @param int $n Minutes.
	 *
	 * @return int
	 */
	public static function minutes( int $n ): int {
		return $n * self::MINUTE;
	}

	/**
	 * N hours in seconds.
	 *
	 * @since 1.0.0
	 *
	 * @param int $n Hours.
	 *
	 * @return int
	 */
	public static function hours( int $n ): int {
		return $n * self::HOUR;
	}

	/**
	 * N days in seconds.
	 *
	 * @since 1.0.0
	 *
	 * @param int $n Days.
	 *
	 * @return int
	 */
	public static function days( int $n ): int {
		return $n * self::DAY;
	}

	/**
	 * N weeks in seconds.
	 *
	 * @since 1.0.0
	 *
	 * @param int $n Weeks.
	 *
	 * @return int
	 */
	public static function weeks( int $n ): int {
		return $n * self::WEEK;
	}
}
