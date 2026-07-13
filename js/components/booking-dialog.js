(function() {
    'use strict';

    const pad = value => String(value).padStart(2, '0');

    /** Zweck: Zeigt das Buchungsformular und übergibt Formularwerte an den Buchungsworkflow. */
    class BookingDialog {
        constructor(dialog, form, onSubmit) {
            this.dialog = dialog;
            this.form = form;
            this.onSubmit = onSubmit;
            this.form.addEventListener('submit', event => this.submit(event));
            this.dialog.addEventListener('cancel', event => { event.preventDefault(); this.close(); });
            this.dialog.querySelectorAll('[data-dialog-close]').forEach(button => button.addEventListener('click', () => this.close()));
        }

        setRooms(rooms) {
            const options = rooms.map(room => {
                const option = document.createElement('option');
                option.value = String(room.id);
                option.textContent = room.name;
                return option;
            });
            this.form.elements.roomId.replaceChildren(...options);
        }

        create(room, date) {
            this.form.reset();
            this.form.elements.id.value = '';
            this.form.elements.roomId.value = String(room.id);
            this.form.elements.date.value = date;
            this.form.elements.startTime.value = '08:00';
            this.form.elements.endTime.value = '09:00';
            this.open('Raumbuchung anlegen');
        }

        edit(booking) {
            const start = this.localParts(booking.startsAt);
            const end = this.localParts(booking.endsAt);
            this.form.elements.id.value = String(booking.id);
            this.form.elements.roomId.value = String(booking.roomId);
            this.form.elements.date.value = start.date;
            this.form.elements.startTime.value = start.time;
            this.form.elements.endTime.value = end.time;
            this.form.elements.purpose.value = booking.purpose;
            this.form.elements.title.value = booking.title;
            this.open('Raumbuchung bearbeiten');
        }

        open(title) {
            this.dialog.querySelector('h2').textContent = title;
            this.dialog.showModal();
        }

        close() {
            this.dialog.close();
        }

        async submit(event) {
            event.preventDefault();
            const values = new FormData(this.form);
            const date = values.get('date');
            await this.onSubmit({
                id: Number(values.get('id') || 0),
                payload: {
                    roomId: Number(values.get('roomId')),
                    start: `${date}T${values.get('startTime')}`,
                    end: `${date}T${values.get('endTime')}`,
                    purpose: String(values.get('purpose') || ''),
                    title: String(values.get('title') || ''),
                },
            });
        }

        localParts(value) {
            const date = new Date(value);
            return {
                date: `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}`,
                time: `${pad(date.getHours())}:${pad(date.getMinutes())}`,
            };
        }
    }

    window.AdRoom = window.AdRoom || {};
    window.AdRoom.BookingDialog = BookingDialog;
}());
