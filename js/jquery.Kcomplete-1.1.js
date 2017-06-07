/*
 *  author:		xujiantao - http://www.xujiantao.com
 *
 *	version:	Kcomplete 1.1 - 2013-12-03
 */
(function($){
    $.fn.Kcomplete = function(options){

        $(this).parent().append('<div class="K_complete"><ul></ul></div>');
        $(this).parent().find('.K_complete').width($(this).outerWidth(true)-2);

        var K_COMPLETE = $(this);
        var NUMBER = 0;
        var CURRENT = $(this).siblings('.K_complete');
        var SELECT_NUM, THIS_TEXT, LI_MERGE;
        var options = $.extend({}, $.fn.Kcomplete.defaults, options);

        CURRENT.bind('boxClose', function(){
            $(this).hide().find('ul').html('');
        });

        function keyUpFunc(k)
        {
            switch(k)
            {
                case 40:
                    NUMBER = NUMBER < SELECT_NUM ?  NUMBER + 1 : 1;

                    CURRENT.find('li').removeAttr('class').eq(parseInt(NUMBER - 1)).addClass('active');

                    var thisLiVal = CURRENT.find('li').eq(parseInt(NUMBER - 1)).text();

                    K_COMPLETE.val(thisLiVal);

                    if(options.selectCount == 'scrollbar')
                    {
                        NUMBER > options.scrollBarCount ? CURRENT.scrollTop(CURRENT.scrollTop() + parseInt(options.liHeight)) : CURRENT.scrollTop(0);
                    }
                    break

                case 38:
                    NUMBER <= 1 ? NUMBER = SELECT_NUM : NUMBER = NUMBER - 1;

                    CURRENT.find('li').removeAttr('class').eq(parseInt(NUMBER - 1)).addClass('active');

                    var thisLiVal = CURRENT.find('li').eq(parseInt(NUMBER - 1)).text();

                    K_COMPLETE.val(thisLiVal);

                    if(options.selectCount == 'scrollbar')
                    {
                        if((NUMBER < SELECT_NUM) && ((SELECT_NUM - NUMBER + 1) > options.scrollBarCount))
                        {
                            CURRENT.scrollTop(CURRENT.scrollTop() - parseInt(options.liHeight));
                        }
                        else
                        {
                            CURRENT.scrollTop(SELECT_NUM * parseInt(options.liHeight));
                        }
                    }
                    break

                case 13:
                    CURRENT.trigger('boxClose');
                    break
            }
        }

        K_COMPLETE.keyup(function(event){

            var keyCode = event.which;
            if(keyCode == 38 || keyCode == 40 || keyCode == 13)
            {
                keyUpFunc(keyCode);
            }
            else
            {
                $.get(options.location, {input:K_COMPLETE.val()}, function(datas){
                    if(options.dataType == 'xml')
                    {
                        var startDOM = $(datas).find(K_COMPLETE.val()).find('data')
                    }
                    else if(options.dataType == 'json')
                    {
                        startDOM = $(datas);
                    }

                    eachFunc(startDOM);
                    if($.trim(K_COMPLETE.val()).length && startDOM.length > 0)
                    {
                        NUMBER = 0;
                        CURRENT.show();
                    }
                    else
                    {
                        CURRENT.trigger('boxClose');
                    }
                }, options.dataType);
            }
        });

        function eachFunc(startDOM)
        {
            var offsetLeft = K_COMPLETE.offset().left;
            var offsetTop = K_COMPLETE.offset().top + parseInt(options.liHeight);

            LI_MERGE = '';
            startDOM.each(function(i){
                if(this.value.length > 0)
                {
                    if($(this).text().length == 0)
                    {
                        THIS_TEXT = this.value
                    }
                    else
                    {
                        THIS_TEXT = $(this).text();
                    }

                    if(($.isNumeric(options.selectCount) && (i < options.selectCount)) || options.selectCount.length > 0)
                    {
                        LI_MERGE += '<li>' + THIS_TEXT + '</li>';
                    }
                }
            });

            CURRENT.find('ul').html(LI_MERGE);
            CURRENT.css({'left':offsetLeft, 'top':offsetTop});
            CURRENT.find('li').css({'height':options.liHeight, 'line-height':options.liHeight});
            SELECT_NUM = CURRENT.find('li').size();

            if(options.selectCount == 'scrollbar')
            {
                if(SELECT_NUM < options.scrollBarCount)
                {
                    var scrollHeight = SELECT_NUM * parseInt(options.liHeight)
                }
                else
                {
                    var scrollHeight = options.scrollBarCount * parseInt(options.liHeight)
                }
                CURRENT.css({'height':scrollHeight, 'overflow':'auto'});
            }
        }

        CURRENT.on('click', 'li', function(){
            K_COMPLETE.val($(this).text());
            CURRENT.trigger('boxClose');
            K_COMPLETE.trigger('change');
        });

        $(document).bind('click', function(e){
            var target = $(e.target);
            if(target.closest('.' + CURRENT.attr('class')).length == 0)
            {
                CURRENT.trigger('boxClose');
            }
        })
    }

    $.fn.Kcomplete.version = '1.1';

    $.fn.Kcomplete.defaults = {
        dataType       : 'json',               // json or xml
        location       : '',  				   // if file is xml && datatype is xml  | if file is asp php... && dataype is json
        liHeight       : '22px',               // <li> height
        selectCount    : 'scrollbar',  	       // number or all or scrollbar
        scrollBarCount : 4                     // scrollbar count
    };
})(jQuery);