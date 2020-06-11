//  Start of avatrade Zendesk Widget script
/*
window.zE || (function (e, t, s) {
    var n = window.zE = window.zEmbed = function () { n._.push(arguments) },
    a = n.s = e.createElement(t), r = e.getElementsByTagName(t)[0]; n.set = function (e) {
        n.set._.push(e)
    }, n._ = [], n.set._ = [], a.async = true, a.setAttribute("charset", "utf-8"),
        a.src = "https://static.zdassets.com/ekr/asset_composer.js?key=" + s, n.t = +new Date, a.type = "text/javascript",
        r.parentNode.insertBefore(a, r)
})(document, "script", "860f88f7-ac5e-4283-87f1-ecd65287ff6d");
*/
//  End of avatrade Zendesk Widget script 

zE(function () {
    zE.hide(); // hode bubble
    $zopim(function ()      {
        var zl = $zopim.livechat;

        function updateLangByDomain(l) {
            var domain = (location.hostname.match(/\.(\w+)$/) || [])[1];
            if (domain) {
                switch (domain.toLocaleLowerCase()) {
                    case "cl":
                        l = "es-cl";
                        break;
                }
            }
            return l;
        }

        function getDepartmentName(lan) {
            switch (lan) {
                case "ar": return 'Arabic';
                case "fr-fr":
                case "fr": return 'French';
                case "de-de":
                case "de": return 'German';
                case "it-it":
                case "it": return 'Italian';
                case "pt":
                case "pt_BR":
                case "pt-pt":
                case "pt-br": return 'Portuguese';
                case "ru-ru":
                case "ru": return 'Russian';
                case "es-cl": return 'Chile';
                case "es-es":
                case "es": return 'Spanish';
                case "tr-tr":
                case "tr": return 'Turkish';
                case "zh_CN":
                case "zh-hans":
                case "zh-hant":
                case "cn": return 'Chinese';

                default: return 'English';
            }
        }
        //function getChatLangCode(sl) {
        //    var lang = sl == "undefined" ? document.documentElement.lang : sl;
        //    if (lang.length == 2) return lang;
        //    switch (lang) {
        //        case "fr": return 'fr';
        //        case "de": return 'de';
        //        case "it": return 'it';
        //        case "pt": return 'pt';
        //        case "ru": return 'ru';
        //        case "es": return 'es';
        //        default: return 'en';
        //    }
        //}

       
        var lang = window.zenDeskDepartmentLang;

        zl.setOnConnected(function () {
            var departmentLang = updateLangByDomain(lang);
            var departmentName = getDepartmentName(departmentLang);
            var department = zl.departments.getDepartment(departmentName);

            zl.setLanguage(lang);
            zE.setLocale(lang);

            if (department == 'undefined') { console.log("chat department. not found for lang: " + lang); return; }
            if (department.status == 'offline') {
                zl.setStatus('offline'); // Set the account status to 'offline'
            } else {
                zl.departments.filter(''); // Hide the Drop-down list option in the Pre-Chat Form to select the Department
                zl.departments.setVisitorDepartment(departmentName);
                //zl.window.setTitle('BRAND Support'); // Set the Window Title:
                //zl.addTags("brand_name"); // add a tag
            }
        });
        $zopim.livechat.setOnStatus(bubble);
        function bubble(status) {
            $zopim.livechat.bubble.hide();
            zE.hide();
            if (status == 'online') {
                console.log("chat online");
            }
            else if (status == 'away') {
                console.log("chat away");
            }
            else if (status == 'offline') {
                console.log("chat offline");
            }
        }
    });
});
