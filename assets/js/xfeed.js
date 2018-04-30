var xfeed = {
    elementPath: null,
    url: null,
    documentWidth: null,
    documentHeight: null,
    deviceWidth: null,
    deviceHeight: null,
    vertex: {
        x: null,
        y: null,
    },
    browser: null,
    browserVersion: null,
    os: null,
    osVersion: null,
    mobile: null,
    userAgent: null,

    onFeedbackClick: function(e) {
        // e.stopPropagation();
        // e.preventDefault();

        var parents = [];
        var element = e.target || e.srcElement;

        while (element.parentElement && !element.parentElement.matches('html')) {
            parents.push(element = element.parentElement);
        }

        var domTree = [];
        parents.forEach(function(element) {
            let domSuffix = '';
            if(element.getAttribute('class')) {
                let classes = element.getAttribute('class');
                domSuffix = '.'+classes.split(' ').join('.')
            } else if(element.getAttribute('id')) {
                let ids = element.getAttribute('id');
                domSuffix += '#'+ids.split(' ').join('#')
            }
            domTree.push(element.nodeName.toLowerCase()+domSuffix)
        });

        this.elementPath = domTree.reverse().join(' > ');
        this.url = window.location.href;
        this.documentWidth = document.documentElement.clientWidth;
        this.documentHeight = document.documentElement.clientHeight;
        this.deviceWidth = window.screen.availWidth;
        this.deviceHeight = window.screen.availHeight;
        this.vertex.x = e.pageX;
        this.vertex.y = e.pageY;
        this.userAgent = window.navigator.userAgent;

        this.setBrowserAndOS();
        this.echoValues();
        this.xfeed_close();
    },

    setBrowserAndOS: function() {
        var self = this, ua = window.navigator.userAgent, platform = window.navigator.platform;

        //Internet Explorer
        if ( /MSIE/.test(ua) ) {
            self.browser = 'Internet Explorer';
            if ( /IEMobile/.test(ua) ) {
                self.mobile = 1;
            }
            self.version = /MSIE \d+[.]\d+/.exec(ua)[0].split(' ')[1];
        //Google Chrome
        } else if ( /Chrome/.test(ua) ) {
            //Chromebooks
            if ( /CrOS/.test(ua) ) {
                platform = 'CrOS';
            }
            self.browser = 'Chrome';
            self.version = /Chrome\/[\d\.]+/.exec(ua)[0].split('/')[1];
       // Opera Browser
        } else if ( /Opera/.test(ua) ) {
            self.browser = 'Opera';
            if ( /mini/.test(ua) || /Mobile/.test(ua) ) {
                self.mobile = 1;
            }
        //Android Browser
        } else if ( /Android/.test(ua) ) {
            self.browser = 'Android Webkit Browser';
            self.mobile = 1;
            self.os = /Android\s[\.\d]+/.exec(ua)[0];
        //Mozilla firefox
        } else if ( /Firefox/.test(ua) ) {
            self.browser = 'Firefox';
            if ( /Fennec/.test(ua) ) {
                self.mobile = 1;
            }
            self.version = /Firefox\/[\.\d]+/.exec(ua)[0].split('/')[1];
        //Safari
        } else if ( /Safari/.test(ua) ) {
            self.browser = 'Safari';
            if ( (/iPhone/.test(ua)) || (/iPad/.test(ua)) || (/iPod/.test(ua)) ) {
                self.os = 'iOS';
                self.mobile = 1;
            }
        }

        if ( platform === 'MacIntel' || platform === 'MacPPC' ) {
            self.os = 'Mac OS X';
            self.osversion = /10[\.\_\d]+/.exec(ua)[0];
            if ( /[\_]/.test(self.osversion) ) {
                self.osversion = self.osversion.split('_').join('.');
            }
        } else if ( platform === 'CrOS' ) {
            self.os = 'ChromeOS';
        } else if ( platform === 'Win32' || platform == 'Win64' ) {
            self.os = 'Windows';
        } else if ( !os && /Android/.test(ua) ) {
            self.os = 'Android';
        } else if ( !os && /Linux/.test(platform) ) {
            self.os = 'Linux';
        } else if ( !os && /Windows/.test(ua) ) {
            self.os = 'Windows';
        }
    },

    echoValues: function() {
        console.log("Browser : " + this.browser);
        console.log("Browser version : " + this.version);
        console.log("Operating System : " + this.os);
        console.log("Operating System version : " + this.osversion);
        console.log("Mobile : " + this.mobile);
        console.log('path: '+ this.elementPath);
        console.log('url: '+this.url)
        console.log('device width: '+ this.deviceWidth)
        console.log('device height: '+ this.deviceHeight)
        console.log('document width: '+ this.documentWidth)
        console.log('document height: '+ this.documentHeight)
        console.log('vertex.x: '+ this.vertex.x)
        console.log('vertex.y: '+ this.vertex.y)
        console.log('user agent: '+ this.userAgent)
    },

    displayForm: function() {
        var ajax = new XMLHttpRequest();
        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("demo").innerHTML = this.responseText;
            } else {
                console.log('failed');
            }
        };
        xhttp.open("GET", "ajax_info.txt", true);
        xhttp.send();
    },

};

window.onload = function() {
    document.body.style.cursor = "url(http://localhost/xfeed/xfeed_target.png),auto";
    document.addEventListener('click', function(e) { xfeed.onFeedbackClick(e); });
};
