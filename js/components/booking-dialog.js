(function () {
    'use strict';
    const pad=(value)=>String(value).padStart(2,'0');
    const localParts=(value)=>{ const date=new Date(value); return {date:`${date.getFullYear()}-${pad(date.getMonth()+1)}-${pad(date.getDate())}`,time:`${pad(date.getHours())}:${pad(date.getMinutes())}`}; };
    class BookingDialog {
        constructor(dialog,form,repository,notice,onSaved) { this.dialog=dialog; this.form=form; this.repository=repository; this.notice=notice; this.onSaved=onSaved; this.form.addEventListener('submit',(event)=>this.submit(event)); dialog.querySelectorAll('[data-dialog-close]').forEach((button)=>button.addEventListener('click',()=>dialog.close())); }
        setRooms(rooms){ const select=this.form.elements.roomId; select.replaceChildren(); rooms.forEach((room)=>{ const option=document.createElement('option'); option.value=String(room.id); option.textContent=room.name; select.append(option); }); }
        create(room,date){ this.form.reset(); this.form.elements.id.value=''; this.form.elements.roomId.value=String(room.id); this.form.elements.date.value=date; this.form.elements.startTime.value='08:00'; this.form.elements.endTime.value='09:00'; this.dialog.querySelector('h2').textContent='Raumbuchung anlegen'; this.dialog.showModal(); }
        edit(booking){ const start=localParts(booking.startsAt); const end=localParts(booking.endsAt); this.form.elements.id.value=String(booking.id); this.form.elements.roomId.value=String(booking.roomId); this.form.elements.date.value=start.date; this.form.elements.startTime.value=start.time; this.form.elements.endTime.value=end.time; this.form.elements.purpose.value=booking.purpose; this.dialog.querySelector('h2').textContent='Raumbuchung bearbeiten'; this.dialog.showModal(); }
        async submit(event){ event.preventDefault(); const values=new FormData(this.form); const date=values.get('date'); const payload={roomId:Number(values.get('roomId')),start:`${date}T${values.get('startTime')}`,end:`${date}T${values.get('endTime')}`,purpose:String(values.get('purpose')||'')}; try { const id=Number(values.get('id')||0); if(id) await this.repository.updateBooking(id,payload); else await this.repository.createBooking(payload); this.dialog.close(); this.notice.success('Buchung gespeichert.'); await this.onSaved(); } catch(error){ this.notice.error(error,'Die Buchung konnte nicht gespeichert werden.'); } }
    }
    window.AdRoom=window.AdRoom||{}; window.AdRoom.BookingDialog=BookingDialog;
}());

