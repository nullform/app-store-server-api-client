<?php

namespace Nullform\AppStoreServerApiClient;

use Firebase\JWT\JWT;

/**
 * Various tools for App Store Server API Client.
 */
final class Tools
{
    /**
     * Decode string signed by the App Store in JSON Web Signature format.
     *
     * @param string $signedString
     * @return string
     */
    public static function decodeSignedString(string $signedString): string
    {
        $jwsArray = \explode('.', $signedString);
        $decodedString = '';
        if (!empty($jwsArray[1])) { // Payload.
            $decodedString = JWT::urlsafeB64Decode($jwsArray[1]);
        }
        return $decodedString;
    }
}
