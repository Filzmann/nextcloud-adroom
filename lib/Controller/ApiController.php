<?php

declare(strict_types=1);

namespace OCA\AdRoom\Controller;

use OCA\AdRoom\AppInfo\Application;
use OCA\AdRoom\Exception\BookingConflictException;
use OCA\AdRoom\Service\BookingService;
use OCA\AdRoom\Service\RoomAccessService;
use OCA\AdRoom\Service\RoomService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\Attribute\NoAdminRequired;
use OCP\AppFramework\Http\Attribute\NoCSRFRequired;
use OCP\AppFramework\Http\JSONResponse;
use OCP\IRequest;
use Psr\Log\LoggerInterface;

/** Zweck: Stellt den abgesicherten JSON-Vertrag fuer Monatsplan, Buchungen und Raumstammdaten bereit. */
final class ApiController extends Controller {
    public function __construct(IRequest $request,private RoomAccessService $access,private BookingService $bookings,private RoomService $rooms,private LoggerInterface $logger) { parent::__construct(Application::APP_ID,$request); }

    #[NoAdminRequired]
    #[NoCSRFRequired]
    public function month(string $month): JSONResponse {
        if (!$this->access->canView()) return $this->denied();
        try { return new JSONResponse($this->bookings->month($month,$this->access)); }
        catch (\Throwable $error) { $this->logger->error('Raummonat konnte nicht geladen werden.',['exception'=>$error]); return $this->error('Der Raummonat konnte nicht geladen werden.',Http::STATUS_BAD_REQUEST); }
    }

    #[NoAdminRequired]
    public function createBooking(int $roomId,string $start,string $end,string $purpose): JSONResponse {
        if (!$this->access->canView()) return $this->denied();
        try { return new JSONResponse(['id'=>$this->bookings->create($roomId,$start,$end,$purpose,$this->access->currentUid())],Http::STATUS_CREATED); }
        catch (BookingConflictException $error) { return $this->error($error->getMessage(),Http::STATUS_CONFLICT); }
        catch (\OutOfBoundsException $error) { return $this->error($error->getMessage(),Http::STATUS_NOT_FOUND); }
        catch (\Throwable $error) { $this->logger->warning('Raumbuchung wurde abgelehnt.',['exception'=>$error]); return $this->error('Die Buchung ist ungueltig.',Http::STATUS_BAD_REQUEST); }
    }

    #[NoAdminRequired]
    public function updateBooking(int $id,int $roomId,string $start,string $end,string $purpose): JSONResponse {
        try { $booking=$this->bookings->existing($id); if (!$this->access->canManageBooking($booking)) return $this->denied(); return new JSONResponse(['id'=>$this->bookings->update($booking,$roomId,$start,$end,$purpose)]); }
        catch (BookingConflictException $error) { return $this->error($error->getMessage(),Http::STATUS_CONFLICT); }
        catch (\OutOfBoundsException $error) { return $this->error($error->getMessage(),Http::STATUS_NOT_FOUND); }
        catch (\Throwable $error) { $this->logger->warning('Raumbuchung konnte nicht aktualisiert werden.',['exception'=>$error]); return $this->error('Die Buchung ist ungueltig.',Http::STATUS_BAD_REQUEST); }
    }

    #[NoAdminRequired]
    public function deleteBooking(int $id): JSONResponse {
        try { $booking=$this->bookings->existing($id); if (!$this->access->canManageBooking($booking)) return $this->denied(); $this->bookings->delete($id); return new JSONResponse(['deleted'=>true]); }
        catch (\OutOfBoundsException $error) { return $this->error($error->getMessage(),Http::STATUS_NOT_FOUND); }
        catch (\Throwable $error) { $this->logger->error('Raumbuchung konnte nicht geloescht werden.',['exception'=>$error]); return $this->error('Die Buchung konnte nicht geloescht werden.',Http::STATUS_BAD_REQUEST); }
    }

    #[NoAdminRequired]
    public function createRoom(string $name,string $description='',int $sortOrder=0): JSONResponse {
        if (!$this->access->canManageRooms()) return $this->denied();
        try { return new JSONResponse(['id'=>$this->rooms->save(null,$name,$description,$sortOrder)],Http::STATUS_CREATED); }
        catch (\Throwable $error) { $this->logger->warning('Raum konnte nicht angelegt werden.',['exception'=>$error]); return $this->error('Der Raum konnte nicht gespeichert werden.',Http::STATUS_BAD_REQUEST); }
    }

    #[NoAdminRequired]
    public function updateRoom(int $id,string $name,string $description='',int $sortOrder=0): JSONResponse {
        if (!$this->access->canManageRooms()) return $this->denied();
        try { return new JSONResponse(['id'=>$this->rooms->save($id,$name,$description,$sortOrder)]); }
        catch (\OutOfBoundsException $error) { return $this->error($error->getMessage(),Http::STATUS_NOT_FOUND); }
        catch (\Throwable $error) { $this->logger->warning('Raum konnte nicht aktualisiert werden.',['exception'=>$error]); return $this->error('Der Raum konnte nicht gespeichert werden.',Http::STATUS_BAD_REQUEST); }
    }

    #[NoAdminRequired]
    public function deleteRoom(int $id): JSONResponse {
        if (!$this->access->canManageRooms()) return $this->denied();
        try { $this->rooms->delete($id); return new JSONResponse(['deleted'=>true]); }
        catch (\OutOfBoundsException $error) { return $this->error($error->getMessage(),Http::STATUS_NOT_FOUND); }
        catch (\Throwable $error) { $this->logger->error('Raum konnte nicht geloescht werden.',['exception'=>$error]); return $this->error('Der Raum konnte nicht geloescht werden.',Http::STATUS_BAD_REQUEST); }
    }

    private function denied(): JSONResponse { return $this->error('Keine Berechtigung.',Http::STATUS_FORBIDDEN); }
    private function error(string $message,int $status): JSONResponse { return new JSONResponse(['message'=>$message],$status); }
}

