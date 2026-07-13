(function() {
    'use strict';

    const byId = window.LocalBase.ui.byId;
    const client = new window.LocalBase.api.ApiClient({ appId: 'adroom' });
    const repository = new window.AdRoom.RoomRepository(client);
    const notice = new window.LocalBase.ui.Notice('adr-admin-notice', { baseClass: 'adr-notice', typeClassPrefix: 'is-' });
    const workflow = new window.AdRoom.RoomWorkflow({ repository, notice, reload: load });
    const settings = new window.AdRoom.RoomSettings({
        section: byId('adroom-admin'),
        body: byId('adr-admin-room-body'),
        form: byId('adr-admin-room-form'),
        onCreate: payload => workflow.create(payload),
        onUpdate: (id, payload) => workflow.update(id, payload),
        onRemove: room => workflow.remove(room),
    });

    async function load() {
        try {
            const now = new Date();
            const month = `${now.getFullYear()}-${String(now.getMonth() + 1).padStart(2, '0')}`;
            const state = await repository.month(month);
            if (!state.capabilities?.canManageRooms) throw new Error('Keine Berechtigung zur Raumverwaltung.');
            settings.render(state.rooms, true);
        } catch (error) {
            notice.error(error, 'Die Räume konnten nicht geladen werden.');
            byId('adr-admin-room-form').querySelector('button[type="submit"]').disabled = true;
        }
    }

    void load();
}());
