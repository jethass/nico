/*
Janrain initializations and settings for JUMP.

For more information about these settings, see the following documents:

    http://developers.janrain.com/documentation/widgets/social-sign-in-widget/social-sign-in-widget-api/settings/
    http://developers.janrain.com/documentation/widgets/user-registration-widget/capture-widget-api/settings/
    http://developers.janrain.com/documentation/widgets/social-sharing-widget/sharing-widget-js-api/settings/
*/

(function() {
    if (typeof window.janrain !== 'object') window.janrain = {};
    window.janrain.plex = {};
    window.janrain.settings = {};
    window.janrain.settings.capture = {};
    
    janrain.plex.moduleVersion = '7.x-2.13';

    janrain.settings.packages = ['login', 'capture'];

    // --- Engage Widget -------------------------------------------------------

    //janrain.settings.language = 'en-US';
    janrain.settings.language = 'fr-FR';
    
    janrain.settings.appUrl = '';
    janrain.settings.tokenAction = 'event';
    
    //janrain.settings.tokenUrl = 'http://nicorette.proxym-it.net/';
    janrain.settings.tokenAction = 'event';
    janrain.settings.borderColor = '#ffffff';
    janrain.settings.fontFamily = 'Helvetica, Lucida Grande, Verdana, sans-serif';
    janrain.settings.width = 300;
    janrain.settings.actionText = ' ';

    // --- Capture Widget ------------------------------------------------------

    janrain.settings.capture.appId = '8svhhnw7zaun8u2cns8237vv3a';
    janrain.settings.capture.captureServer = 'https://jj.eu-dev.janraincapture.com';
    janrain.settings.capture.redirectUri = 'http://nicorette.proxym-it.net/';
    janrain.settings.capture.clientId = 'sutmyda5wmwf43fxgcs5u3chg956wjp6';
    janrain.settings.capture.flowName = 'jj_emea_embedded';
    janrain.settings.capture.flowVersion = 'HEAD';
    janrain.settings.capture.registerFlow = 'socialRegistration';
    janrain.settings.capture.setProfileCookie = true;
    janrain.settings.capture.setProfileData = true;
    janrain.settings.capture.keepProfileCookieAfterLogout = true;
    janrain.settings.capture.modalCloseHtml = '<span class="janrain-icon-16 janrain-icon-ex2"></span>';
    janrain.settings.capture.noModalBorderInlineCss = true;
    janrain.settings.capture.responseType = 'token';
    janrain.settings.capture.returnExperienceUserData = ['displayName'];
    janrain.settings.capture.stylesheets = [css_link];
    janrain.settings.capture.mobileStylesheets =  ['http://nicorette.crm/sites/nicorette.crm/themes/nicorette-crm/janrain-capture-screens/stylesheets/janrain_mobile.css'];
    janrain.settings.capture.hasSettings = true;
    janrain.settings.capture.federateEnableSafari = true;

    // --- Mobile WebView ------------------------------------------------------

    //janrain.settings.capture.redirectFlow = true;
    //janrain.settings.popup = false;
    //janrain.settings.tokenAction = 'url';
    //janrain.settings.capture.registerFlow = 'socialMobileRegistration'

    // --- Federate  -----------------------------------------------------------

    //janrain.settings.capture.federate = true;
    //janrain.settings.capture.federateServer = '';
    //janrain.settings.capture.federateXdReceiver = '';
    //janrain.settings.capture.federateLogoutUri = '';
    //janrain.settings.capture.federateLogoutCallback = function() {};
    //janrain.settings.capture.federateEnableSafari = false;

    // --- Backplane -----------------------------------------------------------

    //janrain.settings.capture.backplane = true;
    //janrain.settings.capture.backplaneBusName = '';
    //janrain.settings.capture.backplaneVersion = 2;
    //janrain.settings.capture.backplaneBlock = 20;

    // --- Share widget --------------------------------------------------------

    //janrain.settings.share = {};
    //janrain.settings.packages.push('share');
    //janrain.settings.share.message = "";
    //janrain.settings.share.title = "";
    //janrain.settings.share.url = "";
    //janrain.settings.share.description = "";

    // --- Load URLs -----------------------------------------------------------

    var httpsLoadUrl = "https://rpxnow.com/load/jj-emea-embedded";
    var httpLoadUrl = "http://widget-cdn.rpxnow.com/load/jj-emea-embedded";

    // --- DO NOT EDIT BELOW THIS LINE -----------------------------------------

    function isReady() { janrain.ready = true; };
    if (document.addEventListener) {
        document.addEventListener("DOMContentLoaded", isReady, false);
    } else {
        window.attachEvent('onload', isReady);
    }

    var e = document.createElement('script');
    e.type = 'text/javascript';
    e.id = 'janrainAuthWidget';
    var url = document.location.protocol === 'https:' ? 'https://' : 'http://';
    url += 'd29usylhdk1xyu.cloudfront.net/load/default';
    e.src = url;
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(e, s);
})();
var access_token = '';

function janrainReturnExperience() {
    var span = document.getElementById('traditionalWelcomeName');
    var name = janrain.capture.ui.getReturnExperienceData("displayName");
    if (span && name) {
        span.innerHTML = "Welcome back, " + name + "!";
    }
}
