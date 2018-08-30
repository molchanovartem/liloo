import appointment from './routes/appointment';
import common from './routes/common';
import client from './routes/client';
import portfolio from './routes/portfolio';
import review from './routes/review';
import salon from './routes/salon';
import service from './routes/service';
import serviceGroup from './routes/serviceGroup';
import user from './routes/user';
import master from './routes/master';

export const routes = [].concat(
    common,
    appointment,
    client,
    portfolio,
    review,
    salon,
    service,
    serviceGroup,
    user,

    master
);