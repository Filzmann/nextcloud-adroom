import {readFileSync} from 'node:fs';
import {runInNewContext} from 'node:vm';

const calendarSource=readFileSync(new URL('../../js/components/month-calendar.js',import.meta.url),'utf8');
const timelineSource=readFileSync(new URL('../../js/modules/booking-timeline.js',import.meta.url),'utf8');
const workflowSource=readFileSync(new URL('../../js/modules/booking-workflow.js',import.meta.url),'utf8');
const sources=['models/room.js','models/booking.js','repositories/room-repository.js','components/booking-dialog.js','components/room-settings.js','main.js','admin.js'].map((file)=>readFileSync(new URL(`../../js/${file}`,import.meta.url),'utf8')).join('\n')+calendarSource+timelineSource+workflowSource;
for(const contract of ['class Room extends','class Booking extends','class RoomRepository','class MonthCalendar','class BookingDialog','class BookingWorkflow','class RoomSettings','adroom:add-booking','adr-admin-room-body','canManageRooms','window.confirm','this.title=String','title: String(values.get']) if(!sources.includes(contract)) throw new Error(`Frontendvertrag fehlt: ${contract}`);
for(const contract of ['const sequence = ++loadSequence','if (sequence !== loadSequence) return;','if (sequence === loadSequence) notice.error','let month = formatMonth(new Date())']) if(!sources.includes(contract)) throw new Error(`Monatsladevertrag fehlt: ${contract}`);
for(const contract of ['class BookingTimeline','adr-day-schedule','gridTemplateRows = this.timeline.rows(points)','gridRow = `${this.timeline.line','points(bookings)','rows(points)']) if(!sources.includes(contract)) throw new Error(`Gemeinsamer Zeitachsenvertrag fehlt: ${contract}`);
const context={window:{},Date,String,Set,Math}; runInNewContext(timelineSource,context); runInNewContext(calendarSource,context); const calculator=new context.window.AdRoom.BookingTimeline();
const timeline=calculator.points([
    {startsAt:'2026-07-13T08:00:00',endsAt:'2026-07-13T09:00:00'},
    {startsAt:'2026-07-13T10:00:00',endsAt:'2026-07-13T11:00:00'},
]);
if(timeline.join(',')!=='360,480,540,600,660,1260') throw new Error(`Gemeinsame Zeitachse ist falsch: ${timeline.join(',')}`);
const rows=calculator.rows(timeline);
if(calculator.line(timeline,600)!==4||(rows.match(/minmax\(/g)||[]).length!==timeline.length-1||!rows.includes(', auto)')) throw new Error('Buchungspositionen werden nicht auf flexible gemeinsame Zeitzeilen abgebildet.');
const workflowContext={window:{confirm:()=>true}}; runInNewContext(workflowSource,workflowContext); const calls=[];
const workflow=new workflowContext.window.AdRoom.BookingWorkflow({
    repository:{createBooking:async(payload)=>calls.push(['create',payload]),updateBooking:async(id,payload)=>calls.push(['update',id,payload]),deleteBooking:async(id)=>calls.push(['delete',id])},
    notice:{success:(message)=>calls.push(['success',message]),error:(error,message)=>calls.push(['error',message])},dialog:{close:()=>calls.push(['close'])},reload:async()=>calls.push(['reload']),
});
await workflow.save({id:0,payload:{title:'Team'}}); await workflow.save({id:7,payload:{title:'Sitzung'}}); await workflow.remove({id:7});
if(calls.filter(call=>call[0]==='create').length!==1||calls.filter(call=>call[0]==='update').length!==1||calls.filter(call=>call[0]==='delete').length!==1) throw new Error('Buchungsworkflow unterscheidet Anlegen, Bearbeiten und Löschen nicht korrekt.');
for(const removed of ['adr-tab-settings',"showView('settings')"]) if(sources.includes(removed)) throw new Error(`Administrative Raumverwaltung liegt noch in der Fachansicht: ${removed}`);
console.log('AD Raumplaner frontend smoke test passed');
