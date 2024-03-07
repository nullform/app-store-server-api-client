<?php

// Put your private key in private-key.p8 file.
// Create your own credentials.php with your SANDBOX credentials like this example.

return [
    'appstore_bundle_id'      => '',
    'appstore_issuer_id'      => '',
    'appstore_key_id'         => '',
    'appstore_key'            => \file_get_contents(__DIR__ . '/private-key.p8'),
    'original_transaction_id' => '', // One of your REAL originalTransactionId from Sandbox environment
    'product_id'              => '', // One of your REAL productId from Sandbox environment
];
