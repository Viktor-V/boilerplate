<?php

declare(strict_types=1);

namespace App\AdminLanguage;

use App\AdminCore\Infrastructure\Controller\AbstractController;

final class AdminLanguageRouteName
{
    public const LANGUAGE = AbstractController::ADMIN_CORE_NAME . 'language';
    public const LANGUAGE_PATH = 'language';

    public const LANGUAGE_CREATE = self::LANGUAGE . '_create';
    public const LANGUAGE_DELETE = self::LANGUAGE . '_delete';

    public const LANGUAGE_EDIT_PATH = 'language/{identifier}/edit';
    public const LANGUAGE_EDIT = self::LANGUAGE . '_edit';

    public const LANGUAGE_PRIME = self::LANGUAGE . '_prime';
}
