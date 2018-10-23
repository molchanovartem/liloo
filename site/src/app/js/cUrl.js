const URL_DOMAIN = 'http://liloo';
const URL_SITE = URL_DOMAIN + '/site/web';
const URL_API_SITE = URL_DOMAIN + '/api/site';
const URL_API_COMMON = URL_DOMAIN + '/api/common';

const cUrl = {};

cUrl.getSite = () => URL_SITE;
cUrl.getApiSite = () => URL_API_SITE;
cUrl.getApiCommon = () => URL_API_COMMON;

cUrl.create = (route = '', params = {}) => {
    let url = cUrl.getSite(),
        items = [[url, route].join('/')],
        param = [];

    for (let p in params) {
        param.push([p, params[p]].join('='));
    }

    if (param.length > 0) items.push(param.join('&'));

    return items.join('?');
};