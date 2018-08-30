class Server {

    /**
     * @param int port
     */
    constructor(port = 9090) {
        this.port = port;
        this.connections = {};

        this.init();
    }

    init() {
        this.server = require('http').createServer();
        this.io = require('socket.io')(this.server);

        this.initEvents();
    }

    start() {
        this.server.listen(this.port, () => {
            console.log('server started');
        });
    }

    initEvents() {
        this.io.on('connection', socket => {
            this.addConnection(socket);

            socket.on('disconnecting', () => {
                this.deleteConnection(socket);
            });
        });
    }

    addConnection(socket) {
        let Appointment = require('./appointment/Appointment');

        this.connections[socket.id] = {
            socketId: socket.id,
            appointment: new Appointment(this.io, socket)
        };
    }

    deleteConnection(socket) {
        delete this.connections[socket.id];
    }
}

module.exports = Server;