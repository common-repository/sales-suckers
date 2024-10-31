/////////////////////////
// API
function Api($) {
    if ($ == null) {
        console.errsor('jQuery is missing');
        return false;
    }
    // making an api call
    this.call = async function(url, data) {
        options = {
            dataType: 'json',
            contentType: 'application/json',
            processData: false
        };
        $.extend(options, data);
        if(options.hasOwnProperty('data')) {
            options.data = JSON.stringify(options.data)
        }
        try {
            result = await $.ajax(url, options);
            return result;
        } catch (e) {
            console.error(e);
        }
    };
    // get the url to the sales-suckers api
    this.getUrl = function(version, method) {
        let url = [apiConfig.apiUrl];
        if (version) url.push(version);
        if (method) url.push(method);

        url = url.join('/');
        return url;
    };

    /*
    let headers = new Headers(),
        options = {
            method: 'POST',
            cache: 'no-cache'
        };
    if (transferOptions) options = Object.assign(options, transferOptions);
    if (method != 'login') headers.append('content-type', 'application/json');

    let url = [apiConfig.apiUrl];
    if (version) url.push(version);
    if (method) url.push(method);

    url = url.join('/');

    if (token) headers.append('Authorization', 'Bearer ' + token);

    options.headers = headers;

    if (data) options.body = data;
    let request = new Request(url, options);

    const response = await fetch(request);
    var result = null;
    if (response.status == 200) {
        let contentType = response.headers.get('content-type');
        if (contentType && contentType.includes('application/json')) {
            result = await response.json();
        } else {
            result = await response.text();
        }
    } else {
        return false;
    }

    try {
        if (typeof result == 'string' && result != '') result = JSON.parse(result);
    } catch (e) {
        throw `invalid result ${JSON.stringify(result)}`;
    }
    return result;
    */
}
