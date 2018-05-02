var xfeedPlugin = {

    init: function() {
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
        img.style.width = '50px';
        img.style.position = 'fixed';
        img.style.right = 0;
        img.style.bottom = 0;
        return img;
    },

    beginFeedback: function() {
        var self = this;
        document.getElementById('xfeed_button').addEventListener('click', function() {
            var element = document.createElement('iframe');
            element.setAttribute('id', 'xfeed_id_plugin');
            element.setAttribute('src', "http://localhost/xfeed/plugin.html");
            element.style.border = 1;
            element.style.position = 'fixed';
            element.style.right = 0;
            element.style.bottom = 0;
            element.style.width = '100%';
            element.style.height = '100%';
            document.body.appendChild(element);
            self.prepareEndFeedback();
        });
    },

    prepareEndFeedback: function() {
        var img = document.getElementById('xfeed_button');
        document.body.removeChild(img);

        var img = this.createImageTemplate('http://localhost/xfeed/plus.png');
        img.setAttribute('id', 'remove_xfeed_button');
        img.style.zIndex = 1000;
        document.body.appendChild(img);
        this.endFeeback();
    },

    endFeeback: function() {
        var self = this;
        document.getElementById('remove_xfeed_button').addEventListener('click', function() {
            var frame = document.getElementById('xfeed_id_plugin');
            document.body.removeChild(frame);
            document.body.removeChild(this);
            self.init();
        });
    },

};

window.onload = function() {
    xfeedPlugin.init();
};
