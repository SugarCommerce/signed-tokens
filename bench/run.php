<?php
declare( strict_types=1 );
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../../bench-lib.php';

use SugarCommerce\SignedTokens\{TokenSigner, Ttl};

$signer = new TokenSigner( TokenSigner::generate_secret() );
$token  = $signer->sign( 'magic-link', array( 'user' => 42 ), Ttl::FIFTEEN_MINUTES );

echo "signed-tokens\n";
bench( 'sign', 50000, static fn() => $signer->sign( 'magic-link', array( 'user' => 42 ), Ttl::FIFTEEN_MINUTES ) );
bench( 'verify (hit)', 50000, static fn() => $signer->verify( 'magic-link', $token ) );
bench( 'verify (miss)', 50000, static fn() => $signer->verify( 'wrong-ns', $token ) );
bench( 'sign_detached', 50000, static fn() => $signer->sign_detached( 'download', array( 'c' => 1, 'p' => 2 ), time() + 3600 ) );
bench_footer();
