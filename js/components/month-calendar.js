(function () {
    'use strict';
    const dayNames=['So.','Mo.','Di.','Mi.','Do.','Fr.','Sa.'];
    const pad=(value)=>String(value).padStart(2,'0');
    const localDate=(value)=>new Date(value);

    class MonthCalendar {
        constructor(head,body) { this.head=head; this.body=body; this.state=null; }
        render(state) { this.state=state; this.renderHead(); this.renderBody(); }
        renderHead() {
            this.head.replaceChildren(); const row=document.createElement('tr'); const day=document.createElement('th'); day.scope='col'; day.textContent='Tag'; row.append(day);
            this.state.rooms.forEach((room)=>{ const th=document.createElement('th'); th.scope='col'; th.textContent=room.name; if(room.description) th.title=room.description; row.append(th); }); this.head.append(row);
        }
        renderBody() {
            this.body.replaceChildren(); const [year,month]=this.state.month.split('-').map(Number); const days=new Date(year,month,0).getDate();
            if(this.state.rooms.length===0){ const row=document.createElement('tr'); const cell=document.createElement('td'); cell.textContent='Noch keine Räume angelegt.'; row.append(cell); this.body.append(row); return; }
            for(let day=1;day<=days;day+=1) this.body.append(this.dayRow(year,month,day));
        }
        dayRow(year,month,day) {
            const date=new Date(year,month-1,day); const dateKey=`${year}-${pad(month)}-${pad(day)}`; const row=document.createElement('tr'); const holiday=this.state.holidays[dateKey];
            if(date.getDay()===6) row.classList.add('is-saturday'); if(date.getDay()===0) row.classList.add('is-sunday'); if(holiday) row.classList.add('is-holiday');
            const label=document.createElement('th'); label.scope='row'; const strong=document.createElement('strong'); strong.textContent=`${dayNames[date.getDay()]}, ${pad(day)}.${pad(month)}.`; label.append(strong);
            if(holiday){ const note=document.createElement('small'); note.textContent=holiday; label.append(note); } row.append(label);
            const scheduleCell=document.createElement('td'); scheduleCell.colSpan=this.state.rooms.length; scheduleCell.className='adr-day-schedule-cell'; scheduleCell.append(this.daySchedule(dateKey)); row.append(scheduleCell); return row;
        }
        daySchedule(dateKey) {
            const bookings=this.state.bookings.filter((booking)=>this.dateKey(booking.startsAt)===dateKey).sort((a,b)=>localDate(a.startsAt)-localDate(b.startsAt));
            const timeline=this.timeline(bookings); const schedule=document.createElement('div'); schedule.className='adr-day-schedule'; schedule.setAttribute('role','group'); schedule.setAttribute('aria-label',`Buchungen am ${dateKey}`);
            schedule.style.gridTemplateColumns=`repeat(${this.state.rooms.length}, minmax(150px, 1fr))`; schedule.style.gridTemplateRows=this.scheduleRows(timeline);
            this.state.rooms.forEach((room,index)=>{
                const lane=document.createElement('div'); lane.className='adr-room-lane'; lane.style.gridColumn=String(index+1); lane.style.gridRow=`1 / ${timeline.length}`; lane.setAttribute('aria-label',room.name);
                const add=document.createElement('button'); add.type='button'; add.className='adr-icon-button adr-add'; add.title=`Buchung für ${room.name} anlegen`; add.setAttribute('aria-label',add.title); add.innerHTML='<span aria-hidden="true">+</span>';
                add.addEventListener('click',()=>window.dispatchEvent(new CustomEvent('adroom:add-booking',{detail:{room,date:dateKey}}))); lane.append(add); schedule.append(lane);
            });
            bookings.forEach((booking)=>{ const roomIndex=this.state.rooms.findIndex((room)=>room.id===booking.roomId); if(roomIndex<0)return; const card=this.bookingCard(booking); card.style.gridColumn=String(roomIndex+1); card.style.gridRow=`${this.gridLine(timeline,this.minute(booking.startsAt))} / ${this.gridLine(timeline,this.minute(booking.endsAt))}`; schedule.append(card); });
            return schedule;
        }
        bookingCard(booking) {
            const card=document.createElement('article'); card.className='adr-booking';
            const time=document.createElement('strong'); time.textContent=`${this.time(booking.startsAt)}–${this.time(booking.endsAt)}`; const purpose=document.createElement('span'); purpose.className='adr-booking-purpose'; purpose.textContent=booking.purpose; const title=document.createElement('span'); title.className='adr-booking-title'; title.textContent=booking.title; const user=document.createElement('small'); user.textContent=booking.userName; card.append(time,purpose,title,user);
            if(booking.canManage){ const actions=document.createElement('div'); actions.className='adr-booking-actions'; actions.append(this.actionButton('✎','Buchung bearbeiten','adroom:edit-booking',booking),this.actionButton('×','Buchung löschen','adroom:delete-booking',booking)); card.append(actions); }
            return card;
        }
        actionButton(icon,label,eventName,booking){ const button=document.createElement('button'); button.type='button'; button.className='adr-icon-button'; button.title=label; button.setAttribute('aria-label',label); button.innerHTML=`<span aria-hidden="true">${icon}</span>`; button.addEventListener('click',()=>window.dispatchEvent(new CustomEvent(eventName,{detail:{booking}}))); return button; }
        timeline(bookings){ return [...new Set([360,1260,...bookings.flatMap((booking)=>[this.minute(booking.startsAt),this.minute(booking.endsAt)])])].sort((a,b)=>a-b); }
        scheduleRows(timeline){ return timeline.slice(0,-1).map((start,index)=>`minmax(${Math.max(6,Math.min(36,Math.round((timeline[index+1]-start)/5)))}px, auto)`).join(' '); }
        gridLine(timeline,minute){ return Math.max(1,timeline.indexOf(minute)+1); }
        minute(value){ const date=localDate(value); return date.getHours()*60+date.getMinutes(); }
        dateKey(value){ const date=localDate(value); return `${date.getFullYear()}-${pad(date.getMonth()+1)}-${pad(date.getDate())}`; }
        time(value){ return localDate(value).toLocaleTimeString('de-DE',{hour:'2-digit',minute:'2-digit'}); }
    }
    window.AdRoom=window.AdRoom||{}; window.AdRoom.MonthCalendar=MonthCalendar;
}());
