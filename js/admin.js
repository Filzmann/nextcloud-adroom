(function () {
    'use strict';

    const byId=window.LocalBase.ui.byId;
    const client=new window.LocalBase.api.ApiClient({appId:'adroom'});
    const repository=new window.AdRoom.RoomRepository(client);
    const notice=new window.LocalBase.ui.Notice('adr-admin-notice',{baseClass:'adr-notice',typeClassPrefix:'is-'});
    const settings=new window.AdRoom.RoomSettings(byId('adroom-admin'),byId('adr-admin-room-body'),byId('adr-admin-room-form'),repository,notice,load);

    async function load(){
        try{
            const month=new Date().toISOString().slice(0,7);
            const state=await repository.month(month);
            if(!state.capabilities?.canManageRooms) throw new Error('Keine Berechtigung zur Raumverwaltung.');
            settings.render(state.rooms,true);
        }catch(error){
            notice.error(error,'Die Räume konnten nicht geladen werden.');
            byId('adr-admin-room-form').querySelector('button[type="submit"]').disabled=true;
        }
    }

    load();
}());
