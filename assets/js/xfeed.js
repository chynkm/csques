var xfeed = {
    elementPath: null,
    url: null,
    documentWidth: null,
    documentHeight: null,
    deviceWidth: null,
    deviceHeight: null,
    parent: {
        x: null,
        y: null,
    },
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
    feedbacks: [],

    init: function() {
        this.initFeedback();
        this.setPageURL();
        this.setBrowserAndOS();
    },

    initFeedback: function() {
        this.createImage();
        this.beginFeedback();
        this.documentWidth = document.documentElement.clientWidth;
        this.documentHeight = document.documentElement.clientHeight;
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
        // img.style.border = '1px solid black';//need to debug click
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
            // @todo - only in live
            // self.displaySpinner();
            self.collectFeedback = true;
            document.body.style.cursor = 'url(http://localhost/xfeed/xfeed_target.png),auto';
            document.addEventListener('dblclick', function(e) { xfeed.onFeedbackClick(e); });
            // @todo manage removal of single click.
            // get all feedback for the page.
            self.executeAjax('GET', self.getFeedbackURL+"?url='"+self.url+"'", self.displayFeedbackPins);
            self.updateAnchorCursors();
            self.prepareEndFeedback();
            self.windowResize();
            // @todo - only in live
            // setTimeout(function(){
                // self.removeSpinner();
            // }, 2000);
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
            element.style.position = 'relative';
            var dimension = element.getClientRects()[0];
            // console.log(element.getBoundingClientRect());
            // this.elementHtml = element.innerHTML; providing incorrect values. @todo need to fix

            this.elementPath = this.getElementPath(element);
            this.documentWidth = document.documentElement.clientWidth;
            this.documentHeight = document.documentElement.clientHeight;
            this.deviceWidth = window.screen.availWidth;
            this.deviceHeight = window.screen.availHeight;
            this.parent.x = e.pageX - dimension.left;
            this.parent.y = e.pageY - dimension.top;
            this.vertex.x = e.pageX + 5; // change according to target icon size
            this.vertex.y = e.pageY - 5; // change according to target icon size
            this.userAgent = window.navigator.userAgent;

            this.echoValues();
            this.displayForm();
            // Should be only run after form submit
            // this.executeAjax('POST', this.saveFeedbackURL, this.addPin, this.collectPostElements());
        }
    },

    getElementPath_OLD: function(element) {
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

    getElementPath: function(el) {
        var fullPath    = 1,
            useNthChild = 1,
            cssPathStr = '',
            testPath = '',
            parents = [],
            parentSelectors = [],
            tagName,
            cssId,
            cssClass,
            tagSelector,
            vagueMatch,
            nth,
            i,
            c;

        while ( el ) {
            vagueMatch = 0;
            tagName = el.nodeName.toLowerCase();
            cssId = ( el.id ) ? ( '#' + el.id ) : false;
            cssClass = ( el.className ) ? ( '.' + el.className.replace(/\s+/g,".") ) : '';
            if ( cssId ) {
                tagSelector = tagName + cssId + cssClass;
            } else if ( cssClass ) {
                tagSelector = tagName + cssClass;
            } else {
                vagueMatch = 1;
                tagSelector = tagName;
            }
            parentSelectors.unshift( tagSelector )
            if ( cssId && !fullPath ) {
                break;
            }
            el = el.parentNode !== document ? el.parentNode : false;
        }

        for ( i = 0; i < parentSelectors.length; i++ ) {
            cssPathStr += ' ' + parentSelectors[i];// + ' ' + cssPathStr;
            if ( useNthChild && !parentSelectors[i].match(/#/) && !parentSelectors[i].match(/^(html|body)$/) ) {
                if ( !parentSelectors[i].match(/\./) || $( cssPathStr ).length > 1 ) {
                    for ( nth = 1, c = el; c.previousElementSibling; c = c.previousElementSibling, nth++ );
                    cssPathStr += ":nth-child(" + nth + ")";
                }
            }
        }
        return cssPathStr.replace(/^[ \t]+|[ \t]+$/, '');
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
        console.log('parent.x: '+ this.parent.x)
        console.log('parent.y: '+ this.parent.y)
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
            "'&device_width="+this.deviceWidth+
            "&device_height="+this.deviceHeight+
            "&document_width="+this.documentWidth+
            "&document_height="+this.documentHeight+
            "&parent_x="+this.parent.x+
            "&parent_y="+this.parent.y+
            "&vertex_x="+this.vertex.x+
            "&vertex_y="+this.vertex.y+
            "&user_agent='"+this.userAgent+"'";
    },

    addPin: function(self, response) {
        var feedback = JSON.parse(response);
        var pin = self.createPin(feedback);
        document.getElementById('xfeed_pin_div').appendChild(pin);
        self.feedbacks.push(feedback);
        console.log(self.feedbacks); // @todo need to verify receipt of location
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
            if(typeof promiseMethod !== 'undefined' && promiseMethod != null) {
                promiseMethod(self, this.responseText);
            }
        };

        if (typeof params === 'undefined') {
            ajax.send();
        } else {
            ajax.send(params);
        }
    },

    displayFeedbackPins: function(self, response) {
        self.feedbacks = JSON.parse(response);
        var divOfPins = document.createElement('div');
        divOfPins.setAttribute('id', 'xfeed_pin_div');
        self.feedbacks.forEach(function(feedback) {
            var pin = self.createPin(feedback);
            self.addResponsiveness(feedback);
            divOfPins.appendChild(pin);
        });
        document.body.appendChild(divOfPins);
    },

    createPin: function(feedback) {
        var pin = this.createImageTemplate('http://xfeed.test/pin.png');
        pin.setAttribute('class', 'xfeed_pin');
        pin.style.position = 'absolute';
        pin.style.left = feedback.vertex_x+'px';
        pin.style.top = feedback.vertex_y+'px';
        return pin;
    },

    removeFeedbackPins: function() {
        var divOfPins = document.getElementById('xfeed_pin_div');
        divOfPins.parentElement.removeChild(divOfPins);
    },

    addResponsiveness: function(feedback) {
        document.elementFromPoint(feedback.vertex_x, feedback.vertex_y).click(function(e) {
            e.stopPropagation();
            e.preventDefault();
            var element = e.target || e.srcElement;
            element.style.position = 'relative';
        });
    },

    windowResize: function() {
        var self = this;
        window.addEventListener('resize', function(e) {
            var pins = document.getElementsByClassName('xfeed_pin');
            var newWinWidth = document.documentElement.clientWidth;
            var newWinHeight = document.documentElement.clientHeight;

            for(var i = 0; i < pins.length; i ++) {
                pins[i].style.left = Math.round(parseInt(pins[i].style.left) * newWinWidth / self.documentWidth)+'px';
                pins[i].style.top = Math.round(parseInt(pins[i].style.top) * newWinHeight / self.documentHeight)+'px';
            }

            self.documentWidth = document.documentElement.clientWidth;
            self.documentHeight =  document.documentElement.clientHeight;
        });
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

    takeScreenshot: function() {
        var screenshot = this.screenshotPage();
        var screenshotUrl = URL.createObjectURL(screenshot);
        window.open(screenshotUrl, '_blank');
    },

    urlsToAbsolute: function(nodeList) {
        if (!nodeList.length) {
            return [];
        }
        var attrName = 'href';
        if (nodeList[0].__proto__ === HTMLImageElement.prototype
        || nodeList[0].__proto__ === HTMLScriptElement.prototype) {
            attrName = 'src';
        }
        nodeList = [].map.call(nodeList, function (el, i) {
            var attr = el.getAttribute(attrName);
            if (!attr) {
                return;
            }
            var absURL = /^(https?|data):/i.test(attr);
            if (absURL) {
                return el;
            } else {
                return el;
            }
        });
        return nodeList;
    },

    screenshotPage: function() {
        this.urlsToAbsolute(document.images);
        this.urlsToAbsolute(document.querySelectorAll("link[rel='stylesheet']"));
        var screenshot = document.documentElement.cloneNode(true);
        var b = document.createElement('base');
        b.href = document.location.protocol + '//' + location.host;
        var head = screenshot.querySelector('head');
        head.insertBefore(b, head.firstChild);
        screenshot.style.pointerEvents = 'none';
        screenshot.style.overflow = 'hidden';
        screenshot.style.webkitUserSelect = 'none';
        screenshot.style.mozUserSelect = 'none';
        screenshot.style.msUserSelect = 'none';
        screenshot.style.oUserSelect = 'none';
        screenshot.style.userSelect = 'none';
        screenshot.dataset.scrollX = window.scrollX;
        screenshot.dataset.scrollY = window.scrollY;
        var script = document.createElement('script');
        script.textContent = '(' + this.screenshotScroll.toString() + ')();';
        screenshot.querySelector('body').appendChild(script);
        var blob = new Blob([screenshot.outerHTML], {
            type: 'text/html'
        });
        return blob;
    },

    screenshotScroll: function() {
        window.addEventListener('DOMContentLoaded', function (e) {
            var scrollX = document.documentElement.dataset.scrollX || 0;
            var scrollY = document.documentElement.dataset.scrollY || 0;
            window.scrollTo(scrollX, scrollY);
        });
    },

    displayForm: function() {
        /*var element = document.createElement('iframe');
        element.setAttribute('id', 'xfeed_form');
        element.setAttribute('src', 'http://xfeed.test/form.html');
        element.style.border = 0;
        element.style.position = 'absolute';
        element.style.left = this.vertex.x+'px';
        element.style.top = this.vertex.y+'px';
        element.style.height = '100%';
        document.body.appendChild(element);*/


        this.executeAjax('GET', 'http://xfeed.test/form.php', this.displayFormFromAjax);

    },

    // @todo - rename the function
    displayFormFromAjax: function(self, response) {
        var element = document.createElement('div');
        element.setAttribute('id', 'xfeed_form');
        element.innerHTML = response;
        element.style.position = 'absolute';
        element.style.left = self.vertex.x+'px';
        element.style.top = self.vertex.y+'px';
        element.style.height = '100%';
        document.body.appendChild(element);
        self.enableCreateButtonInForm();
    },

    enableCreateButtonInForm: function() {
        var a = document.getElementById('xfeed_form');
        // var y = a.contentWindow;
       /* y.document.getElementById('xfeed_form_comment').addEventListener('keyup', function() {
            console.log(this.value);

        });*/
        /*.contentWindow.document.getElementById('xfeed_form_comment').addEventListener('keyup', function() {
            console.log(this.value);

        });*/
    },

};

window.onload = function() {
    xfeed.init();
};
