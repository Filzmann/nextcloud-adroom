import {readFileSync} from 'node:fs';

const sources=['models/room.js','models/booking.js','repositories/room-repository.js','components/month-calendar.js','components/booking-dialog.js','components/room-settings.js','main.js'].map((file)=>readFileSync(new URL(`../../js/${file}`,import.meta.url),'utf8')).join('\n');
for(const contract of ['class Room extends','class Booking extends','class RoomRepository','class MonthCalendar','class BookingDialog','class RoomSettings','adroom:add-booking','adr-tab-settings',"showView('settings')",'aria-selected','canManageRooms','window.confirm']) if(!sources.includes(contract)) throw new Error(`Frontendvertrag fehlt: ${contract}`);
console.log('AD Raumplaner frontend smoke test passed');
