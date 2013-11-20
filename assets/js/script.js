var _dbeesWPvideo = {

    /**
     * List of attributes for srapiq configuration
     */
    attrs: {
        width: null,
        height:null,
        autoStart: null
    },

    /**
     * Core of function, check if _srapiq is embedded, set options and call this.embedVideo
     */
    init: function(att){
        if(window['_srapiq'] == undefined){
            _srapiq = [];
            _srapiq.push(['init', att.apikey]);
            var sr = document.createElement('script'); sr.type = 'text/javascript'; sr.async = true;
            sr.src = '//sdk.digitalbees.it/jssdk-latest.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(sr, s);
        }
        this.setOptions(att);
        this.embedVideo(att.idEl, att.id);
    },

    /**
     * Wrapper for manage configuration of srapiq
     */
    setOptions: function(att){
        if(att.width != undefined){
            this.attrs.width = att.width;
            _srapiq.push(['setOption', 'width', this.attrs.width]);
        }
        if(att.height != undefined){
            this.attrs.height = att.height;
            _srapiq.push(['setOption', 'height', this.attrs.height]);
        }
        if(att.autoStart != undefined){
            this.attrs.autoStart = att.autoStart;
            _srapiq.push(['setOption', 'autoStart', this.attrs.autoStart]);
        }
    },

    /**
     * Wrapper of srapi.EmbedVideo
     */
    embedVideo: function(idEl, id){
       _srapiq.push(['embedVideo', idEl, id]);
    }
};


