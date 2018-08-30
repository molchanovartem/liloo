class Appointment {

    /**
     * @param socket.io io
     * @param socket
     */
    constructor(io, socket) {
        this.io = io;
        this.socket = socket;

        this.init();
    }

    init() {
        this.initEvents()
    }

    initEvents() {
        this.socket.on('appointment.getEvents', () => {
            this.getEvents();
        });
    }

    getEvents() {
        this.socket.emit('appointment.getEvents', {
            start_date: "2018-05-15 09:00",
            end_date:   "2018-05-15 12:00",
            text:   "Meeting",
            holder: "John", //userdata
            room:   "5"     //userdata
        });
    }
}

module.exports = Appointment;