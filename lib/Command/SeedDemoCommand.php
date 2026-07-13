<?php

declare(strict_types=1);

namespace OCA\AdRoom\Command;

use DateTimeImmutable;
use DateTimeZone;
use OCA\AdRoom\Exception\BookingConflictException;
use OCA\AdRoom\Service\BookingService;
use OCA\AdRoom\Service\RoomService;
use OCP\IUserManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/** Zweck: Erzeugt idempotent benannte neutrale Raeume und Beispielbuchungen. */
final class SeedDemoCommand extends Command {
    public function __construct(private RoomService $rooms,private BookingService $bookings,private IUserManager $users) { parent::__construct(); }
    protected function configure(): void { $this->setName('adroom:demo:seed')->setDescription('Erzeugt neutrale Raumplaner-Demodaten.')->addOption('user',null,InputOption::VALUE_REQUIRED,'UID fuer Beispielbuchungen','admin'); }
    protected function execute(InputInterface $input,OutputInterface $output): int {
        $uid=(string)$input->getOption('user');
        if ($this->users->get($uid)===null) { $output->writeln("<error>Benutzer {$uid} existiert nicht.</error>"); return self::FAILURE; }
        $definitions=[
            ['name'=>'Besprechungsraum Nord','description'=>'Kleiner Besprechungsraum','sortOrder'=>10],
            ['name'=>'Besprechungsraum Sued','description'=>'Besprechungsraum fuer Teams','sortOrder'=>20],
            ['name'=>'Konferenzraum','description'=>'Grosser Raum fuer Sitzungen und Fortbildungen','sortOrder'=>30],
        ];
        $existing=[]; foreach ($this->rooms->all() as $room) $existing[$room->name()]=$room->id();
        foreach ($definitions as $definition) if (!isset($existing[$definition['name']])) $existing[$definition['name']]=$this->rooms->save(null,$definition['name'],$definition['description'],$definition['sortOrder']);
        $day=new DateTimeImmutable('next monday',new DateTimeZone('Europe/Berlin'));
        $samples=[['Besprechungsraum Nord','10:00','11:00','Teamgespraech'],['Besprechungsraum Sued','12:00','13:30','Beratung'],['Konferenzraum','14:00','16:00','Fortbildung']];
        $created=0;
        foreach ($samples as [$name,$start,$end,$purpose]) {
            try { $this->bookings->create((int)$existing[$name],$day->format('Y-m-d').'T'.$start,$day->format('Y-m-d').'T'.$end,$purpose,$uid); $created++; }
            catch (BookingConflictException) {}
        }
        $output->writeln('<info>Drei benannte Raeume synchronisiert; '.$created.' Beispielbuchungen erzeugt.</info>');
        return self::SUCCESS;
    }
}

