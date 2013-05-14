/* 
 * partsSelector jQuery plugin
 * Version 0.2
 * 
 * Inspired by multiselect2side (Giovanni Casassa, http://www.senamion.com)
 * reduced features with more keyboard accessibility & compact markup.
 *
 * CHANGES
 * - 0.2, 2010-12-17 3:03:20 WIT:
 *   + Add option to hide/show up-down controls.
 * - 0.1, 2010-12-16 17:56:26 WIT:
 *   + Initial release.
 *
 * TODO:
 *  - Center vertical for controls.
 *
 * Copyright 2010, Zuhdil Herry (zuhdil-at-gmail.com)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 */
(function($){
    var ini = {
        wrapper : 'parts-selector',
        available : 'available-parts',
        selected : 'selected-parts',
        controls : 'controls',
        addControl : 'control-add',
        addLabel : '&#8594;', //'→',
        removeControl : 'control-remove',
        removeLabel : '&#8592;',//'←',
        enableUpDown : true,
        upControl : 'control-up',
        upLabel : '&#8593;', //'↑',
        downControl : 'control-down',
        downLabel : '&#8595;' //'↓'
    };
    $.fn.partsSelector = function(opt) {
        var o = $.extend({}, ini, opt)
        return this.each(function(){
            if (this.tagName == 'SELECT') {
                var el = $(this);
                if (el.attr('multiple')) {
                    buildWidget(el, o);
                }
            }
        });
    }
    function buildWidget(trg, opt) {
        var wdg = init(trg, opt);
        wdg.elOrigin.find('option:not(:selected)').clone().appendTo(wdg.elAvailable);
        wdg.elOrigin.find('option:selected').clone().appendTo(wdg.elSelected).attr('selected', false);
        return initListeners(wdg, opt);
    }
    function init(orig, o) {
        var tpl, cnt, sz = orig.attr('size');
        if (sz < 6) sz = 6;
        tpl ='<div class="'+o.wrapper+'">';
        tpl+='<select name="" class="'+o.available+'" multiple="multiple" size="'+sz+'"></select>';
        tpl+='<div class="'+o.controls+'">';
        tpl+='<input type="button" class="'+o.addControl+'" value="'+o.addLabel+'" />';
        tpl+='<input type="button" class="'+o.removeControl+'" value="'+o.removeLabel+'" />';
        tpl+='</div>';
        tpl+='<select name="" class="'+o.selected+'" multiple="multiple" size="'+sz+'"></select>';
        if (o.enableUpDown) {
            tpl+='<div class="'+o.controls+'">';
            tpl+='<input type="button" class="'+o.upControl+'" value="'+o.upLabel+'" />';
            tpl+='<input type="button" class="'+o.downControl+'" value="'+o.downLabel+'" />';
            tpl+='</div>';
        }
        tpl+='</div>';
        orig.after(tpl).hide();
        cnt = orig.next();
        return {
            elOrigin : orig,
            elAvailable : cnt.find('.'+o.available),
            elSelected : cnt.find('.'+o.selected),
            ctlAdd : cnt.find('.'+o.addControl),
            ctlRemove : cnt.find('.'+o.removeControl),
            ctlUp : cnt.find('.'+o.upControl),
            ctlDown : cnt.find('.'+o.downControl)
        };
    }
    function initListeners(w, o) {
        w.ctlAdd.click(function(){
            handlePartsAddition(w.elAvailable, w.elSelected, w.elOrigin);
            return false;
        });
        w.ctlRemove.click(function(){
            handlePartsRemoval(w.elAvailable, w.elSelected, w.elOrigin);
            return false;
        });
        if (o.enableUpDown) {
            w.ctlUp.click(function(){
                handleMovePartsUp(w.elSelected, w.elOrigin);
                return false;
            });
            w.ctlDown.click(function(){
                handleMovePartsDown(w.elSelected, w.elOrigin);
                return false;
            });
        }
        return w;
    }
    function handlePartsAddition(avail, selec, mirror) {
        avail.find('option:selected').each(function(){
            var elToAdd = $(this),
                elMirror = mirror.find('option[value='+elToAdd.val()+']');
            elToAdd.detach().appendTo(selec).attr('selected', false);
            elMirror.detach().appendTo(mirror).attr('selected',true);
        });
    }
    function handlePartsRemoval(avail, selec, mirror) {
        selec.find('option:selected').each(function(){
            var elToRemove = $(this),
                elMirror = mirror.find('option[value='+elToRemove.val()+']');
            elToRemove.detach().appendTo(avail).attr('selected', false);
            elMirror.attr('selected', false);
        });
    }
    function handleMovePartsUp(hld, mirror) {
        var parts = hld.find('option:selected'),
            pos = parts.first().prev();
        if (pos.length > 0) {
            var mirrorPos = mirror.find('option[value='+pos.val()+']');
            parts.each(function(){
                var elToMove = $(this),
                    elMirror = mirror.find('option[value='+elToMove.val()+']');
                elToMove.detach().insertBefore(pos);
                elMirror.detach().insertBefore(mirrorPos);
            });
        } else {
            $(parts.toArray().reverse()).each(function(){
                var elToMove = $(this),
                    elMirror = mirror.find('option[value='+elToMove.val()+']');
                elToMove.detach().prependTo(hld);
                elMirror.detach().prependTo(mirror);
            });
        }
    }
    function handleMovePartsDown(hld, mirror) {
        var parts = hld.find('option:selected'),
            pos = parts.last().next();
        if (pos.length > 0) {
            var mirrorPos = mirror.find('option[value='+pos.val()+']');
            $(parts.toArray().reverse()).each(function(){
                var elToMove = $(this),
                    elMirror = mirror.find('option[value='+elToMove.val()+']');
                elToMove.detach().insertAfter(pos);
                elMirror.detach().insertAfter(mirrorPos);
            });
        } else {
            parts.each(function(){
                var elToMove = $(this),
                    elMirror = mirror.find('option[value='+elToMove.val()+']');
                elToMove.detach().appendTo(hld);
                elMirror.detach().appendTo(mirror);
            });
        }
    }
})(jQuery);