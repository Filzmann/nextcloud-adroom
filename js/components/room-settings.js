(function () {
    'use strict';
    class RoomSettings {
        constructor(section,body,form,repository,notice,onSaved){ this.section=section; this.body=body; this.form=form; this.repository=repository; this.notice=notice; this.onSaved=onSaved; form.addEventListener('submit',(event)=>this.create(event)); }
        render(rooms,canManage){ this.section.hidden=!canManage; if(!canManage)return; this.body.replaceChildren(); rooms.forEach((room)=>this.body.append(this.row(room))); }
        row(room){ const row=document.createElement('tr'); const name=this.input(room.name,'Raumname'); const description=this.input(room.description,'Beschreibung'); const order=this.input(String(room.sortOrder),'Reihenfolge','number'); const actions=document.createElement('td'); const save=this.button('✓','Raum speichern'); const remove=this.button('×','Raum samt Buchungen löschen');
            save.addEventListener('click',async()=>{ try{ await this.repository.updateRoom(room.id,{name:name.value,description:description.value,sortOrder:Number(order.value)}); this.notice.success('Raum gespeichert.'); await this.onSaved(); }catch(error){this.notice.error(error,'Der Raum konnte nicht gespeichert werden.');} });
            remove.addEventListener('click',async()=>{ if(!window.confirm(`Raum „${room.name}“ und alle zugehörigen Buchungen löschen?`))return; try{await this.repository.deleteRoom(room.id);this.notice.success('Raum gelöscht.');await this.onSaved();}catch(error){this.notice.error(error,'Der Raum konnte nicht gelöscht werden.');} });
            [name,description,order].forEach((input)=>{ const cell=document.createElement('td'); cell.append(input); row.append(cell); }); actions.append(save,remove); row.append(actions); return row; }
        input(value,label,type='text'){ const input=document.createElement('input'); input.type=type; input.value=value; input.setAttribute('aria-label',label); if(type==='number') input.min='0'; return input; }
        button(icon,label){ const button=document.createElement('button'); button.type='button'; button.className='adr-icon-button'; button.title=label; button.setAttribute('aria-label',label); button.innerHTML=`<span aria-hidden="true">${icon}</span>`; return button; }
        async create(event){ event.preventDefault(); const data=new FormData(this.form); try{await this.repository.createRoom({name:String(data.get('name')||''),description:String(data.get('description')||''),sortOrder:Number(data.get('sortOrder')||0)});this.form.reset();this.notice.success('Raum angelegt.');await this.onSaved();}catch(error){this.notice.error(error,'Der Raum konnte nicht angelegt werden.');} }
    }
    window.AdRoom=window.AdRoom||{}; window.AdRoom.RoomSettings=RoomSettings;
}());

