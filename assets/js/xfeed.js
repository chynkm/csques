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
    collectFeedback: false,
    elementHtml: null,
    saveFeedbackURL: 'http://xfeed.test/save_feedback.php',
    getFeedbackURL: 'http://xfeed.test/get_feedback.php',

    init: function() {
        this.initFeedback();
        this.setPageURL();
        this.setBrowserAndOS();
    },

    initFeedback: function() {
        this.createImage();
        this.beginFeedback();
    },

    createImage: function() {
        var img = this.createImageTemplate('http://localhost/xfeed/minus.png');
        img.setAttribute('id', 'xfeed_button');
        document.body.appendChild(img);
    },

    createImageTemplate: function(image_path) {
        var img = document.createElement('img');
        img.src = image_path;
        img.alt = 'xfeed_button';
        // img.style.width = '50px';
        img.style.position = 'fixed';
        img.style.right = 0;
        img.style.bottom = 0;
        img.style.border = '1px solid black';//need to debug click
        return img;
    },

    beginFeedback: function() {
        var self = this;
        document.getElementById('xfeed_button').addEventListener('click', function() {
            // @todo display a loader
            // make sure all the succeeding functions executes
            // when the loader is being displayed
            // setTimeout(function(){
                // self.collectFeedback = true;
            // }, 1000);
            self.displaySpinner();
            self.collectFeedback = true;
            document.body.style.cursor = 'url(http://localhost/xfeed/xfeed_target.png),auto';
            document.addEventListener('click', function(e) { xfeed.onFeedbackClick(e); });
            self.updateAnchorCursors();
            self.prepareEndFeedback();
            self.getAllFeedbackForPage();
            setTimeout(function(){
                self.removeSpinner();
            }, 2000);
        });
    },

    updateAnchorCursors: function() {
        var a = document.getElementsByTagName('a');
        for(let i = 0; i < a.length; i++) {
            a[i].style.cursor = 'url(http://localhost/xfeed/xfeed_target.png),auto';
        }
    },

    removeAnchorCursors: function() {
        var a = document.getElementsByTagName('a');
        for(let i = 0; i < a.length; i++) {
            a[i].style.cursor = 'pointer';
        }
    },

    prepareEndFeedback: function() {
        var img = document.getElementById('xfeed_button');
        document.body.removeChild(img);

        var img = this.createImageTemplate('http://localhost/xfeed/plus.png');
        img.setAttribute('id', 'remove_xfeed_button');
        img.style.zIndex = 1000;
        img.style.cursor = 'auto';
        document.body.appendChild(img);
        this.endFeeback();
    },

    endFeeback: function() {
        var self = this;
        document.getElementById('remove_xfeed_button').addEventListener('click', function(e) {
            e.stopPropagation();
            e.preventDefault();

            document.body.removeChild(this);
            document.body.style.cursor = 'auto';
            self.removeAnchorCursors();
            self.removeFeedbackPins();
            self.collectFeedback = false;
            self.initFeedback();
        });
    },

    setPageURL: function() {
        var url = window.location.href, hash = window.location.hash;
        var indexOfHash = url.indexOf(hash) || url.length;
        this.url = url.substr(0, indexOfHash);
    },

    onFeedbackClick: function(e) {
        var element = e.target || e.srcElement;
        if(this.collectFeedback && element.id != 'remove_xfeed_button') {
            e.stopPropagation();
            e.preventDefault();

            // this.elementHtml = element.innerHTML; providing incorrect values. @todo need to fix
            this.elementPath = this.getElementPath(element);
            this.documentWidth = document.documentElement.clientWidth;
            this.documentHeight = document.documentElement.clientHeight;
            this.deviceWidth = window.screen.availWidth;
            this.deviceHeight = window.screen.availHeight;
            this.vertex.x = e.pageX + 5; // change according to target icon size
            this.vertex.y = e.pageY - 5; // change according to target icon size
            this.userAgent = window.navigator.userAgent;

            this.echoValues();
            this.sendFeedback();
        }
    },

    getElementPath: function(element) {
        var parents = [];
        parents.push(element);

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

        return domTree.reverse().join(' > ');
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
        console.log('Browser : '+ this.browser);
        console.log('Browser version : '+ this.version);
        console.log('Operating System : '+ this.os);
        console.log('Operating System version : '+ this.osversion);
        console.log('Mobile : '+ this.mobile);
        console.log('path: '+ this.elementPath);
        console.log('html: '+ this.elementHtml);
        console.log('url: '+ this.url)
        console.log('device width: '+ this.deviceWidth)
        console.log('device height: '+ this.deviceHeight)
        console.log('document width: '+ this.documentWidth)
        console.log('document height: '+ this.documentHeight)
        console.log('vertex.x: '+ this.vertex.x)
        console.log('vertex.y: '+ this.vertex.y)
        console.log('user agent: '+ this.userAgent)
    },

    collectPostElements: function() {
        return "browser='"+this.browser+
            "'&browser_version='"+this.version+
            "'&os='"+this.os+
            "'&os_version='"+this.osversion+
            "'&mobile='"+this.mobile+
            "'&element_path='"+this.elementPath+
            "'&element_html='"+this.elementHtml+
            "'&url='"+this.url+
            "'&device_width='"+this.deviceWidth+
            "'&device_height='"+this.deviceHeight+
            "'&document_width='"+this.documentWidth+
            "'&document_height='"+this.documentHeight+
            "'&vertex_x='"+this.vertex.x+
            "'&vertex_y='"+this.vertex.y+
            "'&user_agent='"+this.userAgent+"'";
    },

    sendFeedback: function() {
        var ajax = new XMLHttpRequest();
        ajax.open('POST', this.saveFeedbackURL, true);
        ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        ajax.onreadystatechange = function () {
            if (this.readyState != 4 || this.status != 200) {
                return;
            }
            console.log(this.responseText);
        };
        ajax.send(this.collectPostElements());
    },

    // promiseMethod to null if you want to exclude it
    executeAjax: function(method, URL, promiseMethod, params) {
        var ajax = new XMLHttpRequest(), self = this;
        ajax.open(method, URL, true);
        if(method == 'POST') {
            ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        }
        ajax.onreadystatechange = function () {
            if (this.readyState != 4 || this.status != 200) {
                return;
            }
            console.log(this.responseText);
            if(typeof promiseMethod === 'undefined' || (typeof promiseMethod !== 'undefined' && promiseMethod == null)) {
                return this.responseText;
            } else {
                promiseMethod(self, this.responseText);
            }
        };

        if (typeof params === 'undefined') {
            ajax.send();
        } else {
            ajax.send(params);
        }
    },

    getAllFeedbackForPage: function() {
        this.executeAjax('GET', this.getFeedbackURL+"?url='"+this.url+"'", this.displayFeedbackPins);
    },

    displayFeedbackPins: function(self, response) {
        var feedbacks = JSON.parse(response);
        var divOfPins = document.createElement('div');
        divOfPins.setAttribute('id', 'xfeed_pin_div');
        feedbacks.forEach(function(feedback) {
            var pin = self.createImageTemplate('http://xfeed.test/pin.png');
            pin.setAttribute('class', 'xfeed_pin');
            pin.style.position = 'absolute';
            pin.style.left = feedback.vertex_x+'px';
            pin.style.top = feedback.vertex_y+'px';
            divOfPins.appendChild(pin);
        });
        document.body.appendChild(divOfPins);
    },

    removeFeedbackPins: function() {
        var divOfPins = document.getElementById('xfeed_pin_div');
        divOfPins.parentElement.removeChild(divOfPins);
    },

    displaySpinner: function() {
        var divOverlay = document.createElement('div');
        divOverlay.setAttribute('id', 'xfeed_div_overlay');
        divOverlay.style.position = 'fixed';
        divOverlay.style.width = '100%';
        divOverlay.style.height = '100%';
        divOverlay.style.background = 'rgba(0,0,0,0.5) url(http://xfeed.test/spinner.gif) center center no-repeat';
        divOverlay.style.zIndex = 2;
        divOverlay.style.top = 0;
        divOverlay.style.left = 0;
        divOverlay.style.right = 0;
        divOverlay.style.bottom = 0;
        document.body.appendChild(divOverlay);
    },

    removeSpinner: function() {
        var divOverlay = document.getElementById('xfeed_div_overlay');
        divOverlay.parentElement.removeChild(divOverlay);
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
    xfeed.init();
};
