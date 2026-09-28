<?php

declare(strict_types=1);

namespace App\Enums;

enum SessionStatus: string
{
    case VerificationLinkSent = 'verification-link-sent';
}
