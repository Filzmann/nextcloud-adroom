(function () {
    'use strict';
    class RoomRepository {
        constructor(client) { this.client=client; }
        async month(month) { const data=await this.client.request(`/api/month/${this.client.encode(month)}`); return {...data,rooms:window.AdRoom.Room.get_all(data.rooms),bookings:window.AdRoom.Booking.get_all(data.bookings)}; }
        createBooking(payload) { return this.client.request('/api/bookings',{method:'POST',body:JSON.stringify(payload)}); }
        updateBooking(id,payload) { return this.client.request(`/api/bookings/${id}`,{method:'PUT',body:JSON.stringify(payload)}); }
        deleteBooking(id) { return this.client.request(`/api/bookings/${id}`,{method:'DELETE'}); }
        createRoom(payload) { return this.client.request('/api/rooms',{method:'POST',body:JSON.stringify(payload)}); }
        updateRoom(id,payload) { return this.client.request(`/api/rooms/${id}`,{method:'PUT',body:JSON.stringify(payload)}); }
        deleteRoom(id) { return this.client.request(`/api/rooms/${id}`,{method:'DELETE'}); }
    }
    window.AdRoom=window.AdRoom||{}; window.AdRoom.RoomRepository=RoomRepository;
}());

