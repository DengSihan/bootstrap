import config from '@/config';

export function cookieFromRequest(request, key){
    if (!request.headers.cookie) {
        return;
    }
    const cookie = request.headers.cookie.split(';').find(
        c => c.trim().startsWith(`${key}=`)
    );
    if (cookie) {
        return cookie.split('=')[1];
    }
}

export function localeFromRequest(request){
    const url = request.originalUrl;
    let locale = url.split('/')[1];
    return config.locale.available.includes(locale) ? locale : config.locale.default;
}

export function removeEmptyKeyInObject(obj){
    let result = {};
    for (const [key, value] of Object.entries(obj)) {
        if (!!value) result[key] = value;
    }
    return result;
}
