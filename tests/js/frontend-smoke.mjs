import {readFileSync} from 'node:fs';

const sources=['models/room.js','models/booking.js','repositories/room-repository.js','components/month-calendar.js','components/booking-dialog.js','components/room-settings.js','main.js','admin.js'].map((file)=>readFileSync(new URL(`../../js/${file}`,import.meta.url),'utf8')).join('\n');
for(const contract of ['class Room extends','class Booking extends','class RoomRepository','class MonthCalendar','class BookingDialog','class RoomSettings','adroom:add-booking','adr-admin-room-body','canManageRooms','window.confirm','this.title=String','title:String(values.get']) if(!sources.includes(contract)) throw new Error(`Frontendvertrag fehlt: ${contract}`);
for(const removed of ['adr-tab-settings',"showView('settings')"]) if(sources.includes(removed)) throw new Error(`Administrative Raumverwaltung liegt noch in der Fachansicht: ${removed}`);
console.log('AD Raumplaner frontend smoke test passed');
