(function() {
    'use strict';

    const byId = window.LocalBase.ui.byId;
    const client = new window.LocalBase.api.ApiClient({ appId: 'adroom' });
    const repository = new window.AdRoom.RoomRepository(client);
    const notice = new window.LocalBase.ui.Notice('adr-notice', { baseClass: 'adr-notice', typeClassPrefix: 'is-' });
    const calendar = new window.AdRoom.MonthCalendar(byId('adr-calendar-head'), byId('adr-calendar-body'));
    let month = formatMonth(new Date());
    let loadSequence = 0;
    let workflow;
    const dialog = new window.AdRoom.BookingDialog(
        byId('adr-booking-dialog'),
        byId('adr-booking-form'),
        data => workflow.save(data),
    );
    workflow = new window.AdRoom.BookingWorkflow({ repository, notice, dialog, reload: load });

    async function load() {
        const sequence = ++loadSequence;
        const requestedMonth = month;
        try {
            const data = await repository.month(requestedMonth);
            if (sequence !== loadSequence) return;
            byId('adr-month').value = requestedMonth;
            calendar.render(data);
            dialog.setRooms(data.rooms);
        } catch (error) {
            if (sequence === loadSequence) notice.error(error, 'Der Raumplan konnte nicht geladen werden.');
        }
    }

    function shiftMonth(delta) {
        const [year, value] = month.split('-').map(Number);
        const next = new Date(year, value - 1 + delta, 1);
        month = formatMonth(next);
        void load();
    }

    function formatMonth(date) {
        return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`;
    }

    byId('adr-previous').addEventListener('click', () => shiftMonth(-1));
    byId('adr-next').addEventListener('click', () => shiftMonth(1));
    byId('adr-month').addEventListener('change', event => {
        if (!event.target.value) return;
        month = event.target.value;
        void load();
    });
    window.addEventListener('adroom:add-booking', event => dialog.create(event.detail.room, event.detail.date));
    window.addEventListener('adroom:edit-booking', event => dialog.edit(event.detail.booking));
    window.addEventListener('adroom:delete-booking', event => { void workflow.remove(event.detail.booking); });
    void load();
}());
