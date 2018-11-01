function modalAppointmentCreate({userId = null, salonId = null, date}) {
    let window = cWindow.getWindowByType('normalModal');

    if (window) {
        $.get(cUrl.create('appointment/create', {
            [userId ? 'user_id' : 'salon_id']: userId || salonId,
            date: date
        }))
            .done(({content}) => {
                if (content !== undefined) {
                    window.html(content);
                    window.dialog('open');
                }
            });
    }
}