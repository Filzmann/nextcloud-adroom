(function () {
    'use strict';
    class Booking extends window.LocalBase.models.Model {
        constructor(data={}) { super(); this.id=Number(data.id||0); this.roomId=Number(data.roomId||0); this.userUid=String(data.userUid||''); this.userName=String(data.userName||data.userUid||''); this.purpose=String(data.purpose||''); this.startsAt=String(data.startsAt||''); this.endsAt=String(data.endsAt||''); this.canManage=Boolean(data.canManage); }
        toArray() { return {id:this.id,roomId:this.roomId,userUid:this.userUid,userName:this.userName,purpose:this.purpose,startsAt:this.startsAt,endsAt:this.endsAt,canManage:this.canManage}; }
    }
    window.AdRoom=window.AdRoom||{}; window.AdRoom.Booking=Booking;
}());

