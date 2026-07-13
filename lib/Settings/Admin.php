<?php

declare(strict_types=1);

namespace OCA\AdRoom\Settings;

use OCA\AdRoom\AppInfo\Application;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\Settings\ISettings;

/** Zweck: Bindet die Raumstammdaten in den gemeinsamen AD-/BR-Suite-Adminbereich ein. */
final class Admin implements ISettings {
    public function getForm(): TemplateResponse {
        return new TemplateResponse(Application::APP_ID, 'admin');
    }

    public function getSection(): string {
        return 'orgsuite';
    }

    public function getPriority(): int {
        return 30;
    }
}
