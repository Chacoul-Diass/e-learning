var Pushwoosh = Pushwoosh || [];

(function () {
    // statuses of push permission
    const PERMISSION_DEFAULT = "default";
    const PERMISSION_GRANTED = "granted";
    const COOKIE_APP_CODE = "INTERNAL_APP_CODE"; // cookie key of app code (for registered device)
    const COOKIE_HWID = "INTERNAL_HWID"; // cookie key of hwid (for registered device)
    const COOKIE_USER_ID = "INTERNAL_USER_ID"; // cookie key of user id
    const COOKIE_IS_DEVICE_REGISTER = "INTERNAL_IS_DEVICE_REGISTER"; // cookie key status device is register
    const COOKIE_IS_DEVICE_ASSOCIATED = "COOKIE_IS_DEVICE_ASSOCIATED"; // cookie key status device is already associated with user id

    // log
    const NEED_LOG = true;

    // base configuration
    // set your credentials here
    let APP_CODE = "D80F0-0BB8F"; // app code
    const CURRENT_USER_ID = ""; // user name (optional) if not exist set empty string!
    let COOKIE_DOMAIN = "localhost"; // domain on which cookies are available, should start with "."
    // e.g. ".avatrade.com"
    const COOKIE_MAX_AGE = 60 * 60 * 24 * 365; // time of cookie expiration

    executeBusinessLogic();

    const hostName = window.location.hostname

    if (hostName !== "localhost") {
        COOKIE_DOMAIN = "." + hostName.split('.').slice(1).join('.')
        switch (
        hostName.slice(0, hostName.indexOf("."))
        ) {
            case "stg":
            case "mystgvip":
                APP_CODE = "02CDF-8B2E7";
                break;
            case "qa":
            case "wpqa":
            case "myqa2":
                APP_CODE = "F729A-CE94A";
                break;
            case "myvip":
            case "www":
            default:
                APP_CODE = "D80F0-0BB8F";
                break;
        }
    } else {
        APP_CODE = "F729A-CE94A";
    }
    
    const isProd = APP_CODE === "D80F0-0BB8F";

    Pushwoosh.push([
        "init",
        {
            logLevel: isProd ? "error" : "info", // possible values: error, info, debug
            applicationCode: APP_CODE, // you application code from Pushwoosh Control Panel
            safariWebsitePushID: hostName, //  unique reverse-domain string, obtained in you Apple Developer Portal. Only needed if you send push notifications to Safari browser
            defaultNotificationTitle: "Pushwoosh", // sets a default title for push notifications
            autoSubscribe: false, // or true. If true, prompts a user to subscribe for pushes upon SDK initialization
            serviceWorkerUrl: "pushwoosh-service-worker.js"
        }
    ]);

    function executeBusinessLogic() {
        log("INFO: RUN BUSINESS LOGIC");

        const isDeviceAssociated = getStatusIsDeviceAssociatedFromCookie();

        const appCodeFromCookie = getAppCodeFromCookie();
        const hwidFromCookie = getHwidFromCookie();
        const userIdFromCookie = getUserIdFromCookie();

        const isDeviceRegister = getStatusIsDeviceRegisterFromCookie();

        // device already will be associated with user id => exit
        if (isDeviceAssociated) {
            log("INFO: DEVICE ALREADY ASSOCIATED");

            return;
        }

        // current user id get from cookie or from config
        const userId = userIdFromCookie || CURRENT_USER_ID;

        // if can receive user id -> set (or update) to cookie (to work with him in other domains)
        if (userId) {
            setUserIdToCookie(userId);
        }

        // if we have appCode from cookie
        // and we have device hwid
        // and device can receive push notifications
        // and now we have user id
        // we need associate device with user id
        if (appCodeFromCookie && hwidFromCookie && isDeviceRegister && userId) {
            Pushwoosh.push(function () {
                associateDeviceWithUser(appCodeFromCookie, hwidFromCookie, userId);
            });

            return;
        }

        // we can not associate device now
        // if device register already we not need ask subscribe again
        if (isDeviceRegister) {
            log("INFO: DEVICE ALREADY REGISTER, BUT CANT FIND USER ID");

            return;
        }

        // we can not associate device now
        // we must try to get the missing parameters
        Pushwoosh.push(function () {
            const permission = Pushwoosh.driver.getPermission();

            switch (permission) {
                case PERMISSION_DEFAULT:
                    executeUseCasePermissionDefault();
                    break;
                case PERMISSION_GRANTED:
                    executeUseCasePermissionGranted();
                    break;
            }
        });

        function executeUseCasePermissionDefault() {
            log("INFO: EXECUTE USE CASE PERMISSION DEFAULT");

            //showSubscriptionWidget(); // TODO: uncomment when start to work on pushwoosh again

            Pushwoosh.push([
                "onSubscribe",
                function () {
                    executeUseCasePermissionGranted();
                }
            ]);

            Pushwoosh.push([
                "onHideNotificationPermissionDialog",
                function (permission) {
                    if (permission !== "default") {
                        hideSubscriptionWidget();
                    }
                }
            ]);
        }

        function executeUseCasePermissionGranted() {
            log("INFO: EXECUTE USE CASE PERMISSION GRANTED");

            // or we can receive app code and hwid
            Pushwoosh.getHWID().then(function (hwid) {
                setAppCodeToCookie(APP_CODE);
                setHwidToCookie(hwid);
                setStatusIsDeviceRegisterToCookie(1);

                if (userId) {
                    associateDeviceWithUser(APP_CODE, hwid, userId);
                }
            });
        }

        function associateDeviceWithUser(appCode, hwid, userId) {
            log("INFO: ASSOCIATE DEVICE WITH USER ID");

            Pushwoosh.apiClient
                .registerUser({
                    application: appCode,
                    hwid: hwid,
                    userId: userId,
                    device_type: Pushwoosh.platformChecker.getPlatformType()
                })
                .then(function () {
                    setStatusIsDeviceAssociatedToCookie(1);
                });
        }
    }

    function showSubscriptionWidget() {
        document.getElementById("widget") && document.getElementById("widget").classList.add("widget_state_show");
    }

    function hideSubscriptionWidget() {
        document.getElementById("widget") && document.getElementById("widget").classList.remove("widget_state_show");
    }

    // === helpers ===
    function getAppCodeFromCookie() {
        return getCookieValue(COOKIE_APP_CODE);
    }

    function setAppCodeToCookie(code) {
        setCookieValue(COOKIE_APP_CODE, code);
    }

    function getHwidFromCookie() {
        return getCookieValue(COOKIE_HWID);
    }

    function setHwidToCookie(hwid) {
        setCookieValue(COOKIE_HWID, hwid);
    }

    function getUserIdFromCookie() {
        return getCookieValue(COOKIE_USER_ID);
    }

    function setUserIdToCookie(id) {
        setCookieValue(COOKIE_USER_ID, id);
    }

    function getStatusIsDeviceRegisterFromCookie() {
        return getCookieValue(COOKIE_IS_DEVICE_REGISTER);
    }

    function setStatusIsDeviceRegisterToCookie(status) {
        setCookieValue(COOKIE_IS_DEVICE_REGISTER, status);
    }

    function getStatusIsDeviceAssociatedFromCookie() {
        return getCookieValue(COOKIE_IS_DEVICE_ASSOCIATED);
    }

    function setStatusIsDeviceAssociatedToCookie(status) {
        setCookieValue(COOKIE_IS_DEVICE_ASSOCIATED, status);
    }

    function setCookieValue(name, value) {
        name = encodeURIComponent(name);
        value = encodeURIComponent(value);

        document.cookie =
            name +
            "=" +
            value +
            "; path=/; domain=" +
            COOKIE_DOMAIN +
            "; max-age=" +
            COOKIE_MAX_AGE +
            ";";
    }

    function getCookieValue(name) {
        let matches = document.cookie.match(
            new RegExp(
                "(?:^|; )" +
                name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, "\\$1") +
                "=([^;]*)"
            )
        );
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

    function log(text) {
        if (NEED_LOG) {
            console.log(text);
        }
    }
})();