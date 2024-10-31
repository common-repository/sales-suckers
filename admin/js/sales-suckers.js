function SalesSuckers(api, config) {
    // properties
    this.config = config || null;
    this.api = api || null;
    this.token = null;
    this.user = null;
    this.customer = null;
    this.domain = null;

    // check if config is valid
    if (
        !config.hasOwnProperty('username') ||
        !config.hasOwnProperty('password') ||
        !config.hasOwnProperty('rememberMe')
    ) {
        throw 'missing properties in the config [username, password, rememberMe] required';
    }
    // check if api is valid
    if (api == null || typeof api != 'object') {
        throw 'api does not exists';
    }

    // login and save the token

    // methods
    this.login = async (username, password) => {
        let config = {
                data: {
                    username: username,
                    password: password
                },
                method: 'POST'
            },
            loginJson = null;
        try {
            loginJson = await this.api.call(this.api.getUrl('v1', 'login/do'), config);
        } catch (e) {
            throw 'can not log in';
        }
        if (
            loginJson == null ||
            !loginJson.hasOwnProperty('user') ||
            !loginJson.hasOwnProperty('access_token') ||
            !loginJson.hasOwnProperty('expires_in')
        ) {
            return false;
        }

        this.token = loginJson.access_token;
        this.user = loginJson.user;
        window.setTimeout(this.logoutWarning, (loginJson.expires_in - 60) * 1000);

        return true;
    };

    this.getDomains = async () => {
        let options = {
            headers: {
                'Authorization': 'Bearer ' +this.token
            },
            method: 'GET'
        };
        const data = await this.api.call(this.api.getUrl('v1', `User/${this.user.id}/domains`), options);
        return data;
    };

    this.getCode = async config => {
        let options = {
            headers: {
                'Authorization': 'Bearer ' +this.token
            },
            method: 'GET'
        };
        const data = await this.api.call(this.api.getUrl('v1', `Code/${config.customer}/${config.domain}`), options);
        return data;
    };

    this.logoutWarning = () => {
        alert('you are now logged out');
    };
}
