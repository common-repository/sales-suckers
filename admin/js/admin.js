/////////////////////////
// Config
var sasu = null;

const config = {
    username: '',
    password: '',
    rememberMe: false
};
const apiConfig = {
    apiUrl: 'https://wunderpus.azurewebsites.net/api'
};

/////////////////////////
// Dom Ready
(function ($) {
    $(function () {
        if (document.getElementById('plugin_salessuckers_connector') != null) {
            $.extend({}, config);
            var api = new Api($);
            sasu = new SalesSuckers(api, config);
            if (sasuIsLoginShown == true) {
                // show('#sasu_start_loader', false);
                salessuckers_show('#sasu_login', true);
            } else {
                salessuckers_show('#sasu_button_save', true);
                salessuckers_show('#sasu_button_recheck', true);
                salessuckers_show('#sasu_config', true);
            }
            // bind javascript events
            $('#username, #password').on('keypress', function (e) {
                if (e.which == 13) {
                    e.preventDefault();
                    salessuckers_login();
                }
            });
            $('.js-action-login').on('click', function () { salessuckers_login(); });
            $('.js-action-recheck').on('click', salessuckers_recheck);
            $('.js-action-reload').on('click', function () {
                window.location.reload();
            });

        }
    });
})(jQuery);

/////////////////////////
// Page Methods
function salessuckers_show(selector, show) {
    if (selector == null) return false;
    if (show == true) jQuery(selector).removeClass('sasu-hidden');
    else jQuery(selector).addClass('sasu-hidden');
}
function salessuckers_recheck() {
    salessuckers_show('#sasu_login', true);
    salessuckers_show('#sasu_config', false);
    salessuckers_show('#sasu_button_save', false);
    salessuckers_show('#sasu_button_recheck', false);
};
async function salessuckers_login() {
    salessuckers_show('#sasu_login', false);
    salessuckers_show('#sasu_domain_loader', true);
    // try to login
    const isLoggedIn = await sasu.login(
        jQuery('#username').val(),
        jQuery('#password').val()
    );
    // when loggedin, get the user data
    if (isLoggedIn) {
        // show error message
        salessuckers_show('#sasu_login_successfull', true);
        window.setTimeout(() => {
            salessuckers_show('#sasu_login_successfull', false);
        }, 4000);

        // load the available domains
        const list = await sasu.getDomains();
        // check if the domain was found in the urls
        const domainsFound = list.filter(domain => {
            return domain.url == window.location.host;
        });
        if (domainsFound.length == 1) {
            salessuckers_selectDomain({
                customer: domainsFound[0].customerId,
                domain: domainsFound[0].id,
                name: domainsFound[0].name,
                url: domainsFound[0].url
            });
        } else {
            // create html list, for selecting be the user
            let html = [];
            list.map(domain => {
                html.push(
                    `<a class="button" data-customer="${domain.customerId}" data-domain="${domain.id}" data-url="${domain.url
                    }" data-name="${domain.name}">${domain.name} <span class="sasu-lighter">${domain.url}</span></a>`
                );
            });
            document.getElementById('sasu_domain_list').innerHTML = html.join('');
            const listEntries = document.getElementById('sasu_domain_list').querySelectorAll('a[data-domain]');
            for (let i = 0; i < listEntries.length; i++) {
                listEntries[i].addEventListener('click', salessuckers_selectDomain, false);
            }
            salessuckers_show('#sasu_domains', true);
        }
    } else {
        // show error message
        salessuckers_show('#sasu_login_failed', true);
        salessuckers_show('#sasu_login', true);
        window.setTimeout(() => {
            salessuckers_show('#sasu_login_failed', false);
        }, 4000);
    }
    salessuckers_show('#sasu_domain_loader', false);
};
async function salessuckers_selectDomain(e) {
    let data = null;
    if (e == null) return false;
    if (e.target != null) {
        let target = e.target;
        // when clicked on child select target, stop on body
        while (target.getAttribute('data-customer') == null || target.tagName == 'BODY') {
            target = target.parentNode;
        }
        data = {
            customer: target.getAttribute('data-customer'),
            domain: target.getAttribute('data-domain'),
            name: target.getAttribute('data-name'),
            url: target.getAttribute('data-url')
        };
    } else if (e.hasOwnProperty('customer') && e.hasOwnProperty('domain')) {
        data = e;
    }
    if (
        data != null &&
        data.customer != null &&
        data.customer != null &&
        data.domain != null &&
        data.name != null &&
        data.url != null
    ) {
        salessuckers_show('#sasu_domain_loader', true);
        // save the customer and domain id
        document.querySelector('input[data-id="customer_id"]').value = data.customer;
        document.querySelector('input[data-id="domain_id"]').value = data.domain;
        // get the code
        let code = null;
        try {
            code = await sasu.getCode(data);
        } catch (e) {
            salessuckers_show('#sasu_domain_loader', false);
            salessuckers_show('#sasu_select_failed', true);
            window.setTimeout(() => {
                salessuckers_show('#sasu_select_failed', false);
            }, 4000);
            return false;
        }
        document.querySelector('input[data-id="script"]').value = code.script;
        document.querySelector('input[data-id="image"]').value = code.fallbackImage;
        document.querySelector('input[data-id="style"]').value = code.fallbackStyle;

        document.getElementById('sasu_selected_name').innerText = data.name;
        document.getElementById('sasu_selected_url').innerText = data.url;

        salessuckers_show('#sasu_domain_loader', false);
        salessuckers_show('#sasu_domain_choose', true);
    } else {
        salessuckers_show('#sasu_select_failed', true);
        window.setTimeout(() => {
            salessuckers_show('#sasu_select_failed', false);
        }, 4000);
    }
};