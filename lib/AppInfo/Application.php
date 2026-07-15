<?php

declare(strict_types=1);

namespace OCA\AdRoom\AppInfo;

use OCA\AdRoom\Listener\IntegrationCapabilityQueryListener;
use OCA\AdRoom\Listener\StandaloneNavigationListener;
use OCA\LocalBase\Integration\IntegrationCapabilityQueryEvent;
use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\Navigation\Events\LoadAdditionalEntriesEvent;

/** Zweck: Registriert Raumfähigkeiten und Standalone-Navigation im Nextcloud-Bootstrap. */
final class Application extends App implements IBootstrap {
    public const APP_ID = 'adroom';

    public function __construct(array $urlParams = []) {
        parent::__construct(self::APP_ID, $urlParams);
    }

    public function register(IRegistrationContext $context): void {
        $context->registerEventListener(IntegrationCapabilityQueryEvent::class, IntegrationCapabilityQueryListener::class);
        $context->registerEventListener(LoadAdditionalEntriesEvent::class, StandaloneNavigationListener::class);
    }

    public function boot(IBootContext $context): void {
    }
}
