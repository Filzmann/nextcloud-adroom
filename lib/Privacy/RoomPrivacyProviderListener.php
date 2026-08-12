<?php

declare(strict_types=1);

namespace OCA\AdRoom\Privacy;

use OCA\LocalBase\Privacy\PersonalDataProviderRegistryEvent;
use OCA\LocalBase\Privacy\RetentionProviderRegistryEvent;
use OCP\EventDispatcher\Event;
use OCP\EventDispatcher\IEventListener;

final class RoomPrivacyProviderListener implements IEventListener {
    public function __construct(private RoomPersonalDataProvider $personalData, private RoomRetentionProvider $retention) {}

    public function handle(Event $event): void {
        if ($event instanceof PersonalDataProviderRegistryEvent) $event->register($this->personalData);
        if ($event instanceof RetentionProviderRegistryEvent) $event->register($this->retention);
    }
}
