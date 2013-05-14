/* 
 * flipflopFolding jQuery plugin
 * Version 0.1
 *
 * Copyright 2010, Zuhdil Herry (zuhdil-at-gmail.com)
 * Dual licensed under the MIT or GPL Version 2 licenses.
 */
(function($){
    $.fn.flipflopFolding = function(){
        return this.each(function(){
            buildWidget(this);
        });
    };
    function buildWidget(root) {
        var wrapper = $(root),
            widget = {root:root, expandedPath:[root]},
            activeLink = wrapper.find('a.active'),
            activeNode = activeLink.next().length ?
                activeLink.next().get(0) :
                activeLink.parents('ul:first').get(0);
        wrapper.addClass('flipflopfolding');
        wrapper.delegate('li:has(ul) > a', 'click', function() {
            updateMenuFolds($(this).next().get(0), widget);
            return false;
        });
        wrapper.find('li:has(ul) > a').addClass('collapse');
        wrapper.find('ul').hide();
        // make sure we don't collapse root node
        if (activeNode !== widget.root) {
            updateMenuFolds(activeNode, widget);
        }
    }
    function updateMenuFolds(node, widget) {
        var oldpath = widget.expandedPath,
            newpath = getPath(node, widget.root),
            nodesToToggle = getNodesToToggle(newpath, oldpath);
        toggleNodes(nodesToToggle);
        widget.expandedPath = newpath;
    }
    function getNodesToToggle(newpath, oldpath) {
        // new path is longer or same size as old path
        for (var  i = 0, len = newpath.length; i < len; i++) {
            if (oldpath[i] && newpath[i]===oldpath[i]) {
                continue;
            } else {
                (oldpath = oldpath.slice(i)).reverse();
                return oldpath.concat(newpath.slice(i));
            }
        }
        // old path is longer than new path
        newpath.pop();
        (oldpath = oldpath.slice(len-1)).reverse();
        return oldpath;
    }
    function toggleNodes(nodes) {
        for (var i = 0, len = nodes.length; i < len; i++) {
            $(nodes[i]).toggle().
                prev().toggleClass('collapse expand');
        }
    }
    function getPath(node, root) {
        var path = [];
        while(node) {
            path.unshift(node);
            node = (node !== root) ? $(node).parents('ul:first').get(0) : false;
        }
        return path;
    }
})(jQuery);

