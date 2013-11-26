<script>
    if(window['_srapiq'] == undefined){
        _srapiq = [];
        _srapiq.push(['init', '<?php echo get_option(DIGITALBEES_API_KEY) ?>']);
        var sr = document.createElement('script'); sr.type = 'text/javascript'; sr.async = true;
        sr.src = '//sdk.digitalbees.it/jssdk-latest.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(sr, s);
    }

    var dbees = {
        renderSidebar: function(obj){
            jQuery('#dbees-s-content').empty();
            jQuery('#dbees-s-content').append("<div id='video-cont'></div>");
            _srapiq.push(['setOption', 'width', 290]);
            _srapiq.push(['setOption', 'height', 150]);
            _srapiq.push(['embedVideo', 'video-cont', obj.id]);
            jQuery('#dbees-s-content').append("<ul id='single-video-descr'>" +
                "<li>" +
                "<span class='btitle'>Name: </span>"+obj.name+"<li>" +
                "<span class='btitle'>Creation date: </span>"+obj.creationDate+"<li>" +
                "<span class='btitle'>Content Provider: </span>"+obj.contentProvider+"<li>" +
                "<span class='btitle'>Isrc: </span>"+obj.isrc+"<li>" +
                "<span class='btitle'>Category: </span>"+obj.category+"<li>" +
                "<br><p>Copy this code in your page</p><span class='dbees-tag'>[dbees id="+obj.id+"]</span><li>" +
                "</ul>");
        },
        clickSingleVideo: function(){
            jQuery('.item').click(function(){
                jQuery.ajax({
                    url: 'http://api.digitalbees.it/get/video/'+ jQuery(this).data('id'),
                    data: {apikey: '<?php echo get_option(DIGITALBEES_API_KEY) ?>'},
                    success: function(obj){
                        dbees.renderSidebar(obj);
                        window.parent.jQuery('.media-modal-close').click(function(){
                            if(_srapiq != undefined){
                                _srapiq.getApi().pauseVideo();
                            }
                        });
                    },
                    dataType: 'jsonp'
                });
            })
        }
    };

    jQuery.ajax({
        url: 'http://api.digitalbees.it/list/video',
        data: {
            apikey: '<?php echo get_option(DIGITALBEES_API_KEY) ?>',
            'perPage': 10,
            'sortDirection': 'DESC'
        },
        success: function(videos){
            jQuery.each(videos['data'], function(index, video){
                var d1=new Date(video.creationDate);
                jQuery(".container-items").append("<li class='item' data-id='"+video.id+"'><img src='"+video.stillFrame+"?apikey=<?php echo get_option(DIGITALBEES_API_KEY) ?>'/><p><b>"+video.name+"</b><br>"+d1.toDateString()+"</p></li>");
            })
            var wall = new freewall(".container-items");
            wall.reset({
                'cellW': 200,
                'cellH': 200,
                'onResize': function() {
                    wall['fitWidth']();
                },
                'block': {
                    flex: 1
                },
                'fillGap': false,
                    'gutterX' : 20,
                    'gutterY' : 20
            });
            wall.fitWidth();
            dbees.clickSingleVideo();
            jQuery("input[name='search']").focusout(function(){
                var params = {};
                var urlRequire = 'http://api.digitalbees.it/search/video';
                var camp = undefined;
                var valueQ = '*';
                valueQ = this.value;

                if(jQuery(".attachment-filters").val() == 'title'){
                    camp = "@title: "
                }

                if(jQuery(".attachment-filters").val() == 'metatag'){
                    camp = "@metatag: "
                }

                if(camp != undefined){
                    params['q'] = camp + valueQ;
                } else {
                    params['q'] = valueQ;
                }

                params['apikey']='<?php echo get_option(DIGITALBEES_API_KEY) ?>';
                jQuery.ajax({
                    url: urlRequire,
                    data: params,
                    success: function(videos){
                        jQuery('.container-items').empty();
                        jQuery.each(videos['data'], function(index, video){
                            var d1=new Date(video.creationDate);
                            jQuery(".container-items").append("<li class='item' data-id='"+video.id+"'><img src='"+video.stillFrame+"?apikey=<?php echo get_option(DIGITALBEES_API_KEY) ?>'/><p><b>"+video.name+"</b><br>"+d1.toDateString()+"</p></li>");
                            wall.fitWidth();
                        })
                        dbees.clickSingleVideo();
                    },
                    dataType: 'jsonp'
                });
            })
        },
        dataType: 'jsonp'
    });
</script>
<div class="digitalbees-tab-media">
    <div id="digitalbees-tab-body">
        <div class="media-dbees-toolbar">
            <div class="media-dbees-toolbar-secondary">
                <select class="attachment-filters">
                        <option value="1">Video title and Authors</option>
                        <option value="title">Video title</option>
                        <option value="metatag">Tags</option>
                </select>
            </div>
            <div class="media-dbees-toolbar-primary">
                <input type="search" placeholder="Search" name="search" class="search">
            </div>
        </div>
        <ul class="container-items">
    	</ul>
     </div>
    <div id="digitalbees-sidebar">
        <div id="dbees-s-content"></div>
    </div>
</div>
<div style="clear: both;"></div>