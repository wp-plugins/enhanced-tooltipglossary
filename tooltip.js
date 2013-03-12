var tooltip=function(opts){
    var id = 'tt';
    var alpha = 0;
    var tt,t,c,b,h;
    var ie = document.all ? true : false;
    var methods ={
        show:function(v,w){
            if(tt == null){
                tt = document.createElement('div');
                tt.setAttribute('id',id);
                t = document.createElement('div');
                t.setAttribute('id',id + 'top');
                c = document.createElement('div');
                c.setAttribute('id',id + 'cont');
                 b = document.createElement('div');
                b.setAttribute('id',id + 'bot');
                tt.appendChild(t);
                tt.appendChild(c);
                tt.appendChild(b);
                document.body.appendChild(tt);
                tt.style.opacity = 0;
                tt.style.filter = 'alpha(opacity=0)';
                document.onmousemove = this.pos;
            }
            tt.onclick=function() {
                tt.hide();
            }
            tt.style.display = 'block';
            c.innerHTML = v;
            tt.style.width = 'auto';
            if(!w && ie){
                t.style.display = 'none';
                b.style.display = 'none';
                tt.style.width = tt.offsetWidth;
                t.style.display = 'block';
                b.style.display = 'block';
            }
            if(tt.offsetWidth > opts.maxw){
                tt.style.width = opts.maxw + 'px'
                }
            h = parseInt(tt.offsetHeight) + opts.top;
            clearInterval(tt.timer);
            tt.timer = setInterval(function(){
                methods.fade(1)
                },opts.timer);
        },
        pos:function(e){
            var u = ie ? event.clientY + document.documentElement.scrollTop : e.pageY;
            var l = ie ? event.clientX + document.documentElement.scrollLeft : e.pageX;
            tt.style.top = (u - h) + 'px';
            tt.style.left = (l + opts.left) + 'px';
        },
        fade:function(d){
            var a = alpha;
            if((a != opts.endalpha && d == 1) || (a != 0 && d == -1)){
                var i = opts.speed;
                if(opts.endalpha - a < opts.speed && d == 1){
                    i = opts.endalpha - a;
                }else if(alpha < opts.speed && d == -1){
                    i = a;
                }
                alpha = a + (i * d);
                tt.style.opacity = alpha * .01;
                tt.style.filter = 'alpha(opacity=' + alpha + ')';
            }else{
                clearInterval(tt.timer);
                if(d == -1){
                    tt.style.display = 'none'
                    }
            }
        },
        hide:function(){
            clearInterval(tt.timer);
            tt.timer = setInterval(function(){
                methods.fade(-1)
                },opts.timer);
        }
    };
    return methods;
};
(function($) {
    $.fn.glossaryTooltip = function(options) {
        var opts = {
            top: 3,
            left: 3,
            maxw: 400,
            speed: 10,
            timer: 20,
            endalpha: 95
        };
        $.extend(opts, options);
        var glossarytTip = tooltip(opts);
        return this.each(function() {
            $(this).hover(function() {
                glossarytTip.show($(this).data('tooltip'));
            }, function() {
                glossarytTip.hide();
            });
        });
    }
    $(document).ready(function() {$('[data-tooltip]').glossaryTooltip()});
})(jQuery);
