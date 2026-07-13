import {readFileSync} from 'node:fs';
import {runInNewContext} from 'node:vm';

const calendarSource=readFileSync(new URL('../../js/components/month-calendar.js',import.meta.url),'utf8');
const sources=['models/room.js','models/booking.js','repositories/room-repository.js','components/booking-dialog.js','components/room-settings.js','main.js','admin.js'].map((file)=>readFileSync(new URL(`../../js/${file}`,import.meta.url),'utf8')).join('\n')+calendarSource;
for(const contract of ['class Room extends','class Booking extends','class RoomRepository','class MonthCalendar','class BookingDialog','class RoomSettings','adroom:add-booking','adr-admin-room-body','canManageRooms','window.confirm','this.title=String','title:String(values.get']) if(!sources.includes(contract)) throw new Error(`Frontendvertrag fehlt: ${contract}`);
for(const contract of ['adr-day-schedule','gridTemplateRows=this.scheduleRows(timeline)','gridRow=`${this.gridLine','timeline(bookings)','scheduleRows(timeline)']) if(!sources.includes(contract)) throw new Error(`Gemeinsamer Zeitachsenvertrag fehlt: ${contract}`);
const context={window:{},Date,String,Set,Math}; runInNewContext(calendarSource,context); const calendar=Object.create(context.window.AdRoom.MonthCalendar.prototype);
const timeline=calendar.timeline([
    {startsAt:'2026-07-13T08:00:00',endsAt:'2026-07-13T09:00:00'},
    {startsAt:'2026-07-13T10:00:00',endsAt:'2026-07-13T11:00:00'},
]);
if(timeline.join(',')!=='360,480,540,600,660,1260') throw new Error(`Gemeinsame Zeitachse ist falsch: ${timeline.join(',')}`);
const rows=calendar.scheduleRows(timeline);
if(calendar.gridLine(timeline,600)!==4||(rows.match(/minmax\(/g)||[]).length!==timeline.length-1||!rows.includes(', auto)')) throw new Error('Buchungspositionen werden nicht auf flexible gemeinsame Zeitzeilen abgebildet.');
for(const removed of ['adr-tab-settings',"showView('settings')"]) if(sources.includes(removed)) throw new Error(`Administrative Raumverwaltung liegt noch in der Fachansicht: ${removed}`);
console.log('AD Raumplaner frontend smoke test passed');
