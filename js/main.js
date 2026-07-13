(function () {
    'use strict';
    const byId=window.LocalBase.ui.byId;
    const client=new window.LocalBase.api.ApiClient({appId:'adroom'});
    const repository=new window.AdRoom.RoomRepository(client);
    const notice=new window.LocalBase.ui.Notice('adr-notice',{baseClass:'adr-notice',typeClassPrefix:'is-'});
    const calendar=new window.AdRoom.MonthCalendar(byId('adr-calendar-head'),byId('adr-calendar-body'));
    const dialog=new window.AdRoom.BookingDialog(byId('adr-booking-dialog'),byId('adr-booking-form'),repository,notice,load);
    let month=new Date().toISOString().slice(0,7); let state=null;
    async function load(){ try{state=await repository.month(month);byId('adr-month').value=month;calendar.render(state);dialog.setRooms(state.rooms);}catch(error){notice.error(error,'Der Raumplan konnte nicht geladen werden.');} }
    function shiftMonth(delta){ const [year,value]=month.split('-').map(Number); const next=new Date(year,value-1+delta,1); month=`${next.getFullYear()}-${String(next.getMonth()+1).padStart(2,'0')}`; load(); }
    byId('adr-previous').addEventListener('click',()=>shiftMonth(-1)); byId('adr-next').addEventListener('click',()=>shiftMonth(1)); byId('adr-month').addEventListener('change',(event)=>{if(event.target.value){month=event.target.value;load();}});
    window.addEventListener('adroom:add-booking',(event)=>dialog.create(event.detail.room,event.detail.date)); window.addEventListener('adroom:edit-booking',(event)=>dialog.edit(event.detail.booking));
    window.addEventListener('adroom:delete-booking',async(event)=>{if(!window.confirm('Diese Raumbuchung löschen?'))return;try{await repository.deleteBooking(event.detail.booking.id);notice.success('Buchung gelöscht.');await load();}catch(error){notice.error(error,'Die Buchung konnte nicht gelöscht werden.');}});
    load();
}());
