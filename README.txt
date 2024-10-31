=== Sales-Suckers Connector ===
Contributors: salessuckers
Donate link: https://www.sales-suckers.com
Tags: connector, lead generation, salessuckers, sales-suckers, sale, code, code include
Requires at least: 3.0.1
Tested up to: 5.9.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Stable Tag: 1.0.8
Version: 1.0.8

Connector between Sales-Suckers and Wordpress, to easily integrate the tracking code

== Description ==

This plugin allows the easy integration of the [Sales-Suckers](https://www.sales-suckers.com) tracking code. The tracking code can be placed in the head of in the footer. That's handy if one of them is not available in your theme and to have total control where the code will be placed.

To use this plugin you must have an Sales-Suckers account, otherwise nothing will be included.

### External API
This plugin uses the extrenal API from Sales-Suckers to verify the user, to load his available domains and to get the personalized tracking code.

The following Methods will be used from the API:

**Login**
POST: `/Login/do`
Logs the user in and returns the token and basic infos about the user.
the username and password will be used from the input fields in the admin view of the plugin, no data from your WordPress will be used.
The following data will send in the body
```json
{
  "username": "string",
  "password": "string",
  "rememberMe": true
}
```

**User**
GET: `/User/{userId}/domains`
Returns the available domains for the logged in user.
This methods needs an authorizations header to be attached
`Authorization: Bearer {token}`

**Code**
GET: `/Code/{customerId}/{domainId}`
Returns the code object for the selected domain.
This methods needs an authorizations header to be attached
`Authorization: Bearer {token}`

An API documentation is online available through https://wunderpus.azurewebsites.net/swagger

== Installation ==

## Install plugin as zip
1. To install the plugin, download the zip file
1. Go to your plugins section in the wordpress admin area (`Plugins - Add new`), to add a new plugin
1. Click on the button "Upload Plugin"
1. Choose the plugin zip file from your computer and click "Install Now"
1. When the plugin is installed successfully, click the button "Activate Plugin", to active your new plugin
1. In the list of your plugins, you will find the new plugin "Sales-Suckers Connector", click on the link "Settings", to configure the plugin

Now go to the [configuration section](#configure)

## Install plugin manually

1. To install the plugin, download the zip file and extract it, you will find a folder with the name "salessuckers"
2. Copy the folder "salessuckers" in your wordpress folder `/wp-content/plugins/`
3. Go to your plugins section in the wordpress admin area (`Plugins - Installed Plugins`)
4. In the list of your plugins, you will find the new plugin "Sales-Suckers Connector", click on the link "Activate",
5. Click on the button "Settings" to configure the plugin

Now go to the [configuration section](#configure)

## <a name="configure"></a> Configure plugin

### First Steps and Reload code

Switch to the Sales-Suckers Plugin through (`Settings - Sales-Suckers` or `Plugins - Installed Plugins - Settings`)

Login in with your Sales-Suckers login credentials, by entering the email and password and clicking on "Login". For security reasons, your credentials will  not be saved and used in other places of the application.

After you successfully logged in, the plugin will show you your available websites from Sales-Suckers, or simple selects the domain that matches the current url. Click on the website that is site of your current wordpress page.

If the selected website is correct, click on the button "Yes" to activate the tracking for the domain.

###  Settings

You can disable tracking globally by disabling the checkbox for "Active"

To control, whether the tracking code should be included in the footer `wp_footer` leave the checkbox "Include in Footer" checked. To Include the tracking code in the header `wp_head` uncheck the checkbox.

Click "Save all changes" to update the configuration.


== Changelog ==
= 1.0.8 =
Tested up to 5.9.2
= 1.0.6 =
Tested on 5.4
= 1.0.5 =
Tested on 5.2
= 1.0.4 =
Tested on 5.0.1
= 1.0.3 =
= 1.0.2 =
= 1.0.1 =
* Fix login in firefox
= 1.0.0 =
* Created plugin in english and german
