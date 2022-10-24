import $ from 'jquery';
window.$ = window.jQuery = $;

import bootstrap from 'bootstrap'
import './rateit';
import './toastr';
import './search';

require('jquery.easing');


const mainNavigation = document.querySelector(".main-navigation");
const overlay = mainNavigation.querySelector(".overlay");
const toggler = mainNavigation.querySelector(".navbar-toggler");

const openSideNav = () => mainNavigation.classList.add("active");
const closeSideNav = () => mainNavigation.classList.remove("active");

document.addEventListener("swiped-right", openSideNav);
document.addEventListener("swiped-left", closeSideNav);
toggler.addEventListener("click", openSideNav);
overlay.addEventListener("click", closeSideNav);

//wipper

/*!
 * swiped-events.js - v@version@
 * Pure JavaScript swipe events
 * https://github.com/john-doherty/swiped-events
 * @inspiration https://stackoverflow.com/questions/16348031/disable-scrolling-when-touch-moving-certain-element
 * @author John Doherty <www.johndoherty.info>
 * @license MIT
 */
(function (window, document) {

    'use strict';

    // patch CustomEvent to allow constructor creation (IE/Chrome)
    if (typeof window.CustomEvent !== 'function') {

        window.CustomEvent = function (event, params) {

            params = params || { bubbles: false, cancelable: false, detail: undefined };

            var evt = document.createEvent('CustomEvent');
            evt.initCustomEvent(event, params.bubbles, params.cancelable, params.detail);
            return evt;
        };

        window.CustomEvent.prototype = window.Event.prototype;
    }

    document.addEventListener('touchstart', handleTouchStart, false);
    document.addEventListener('touchmove', handleTouchMove, false);
    document.addEventListener('touchend', handleTouchEnd, false);

    var xDown = null;
    var yDown = null;
    var xDiff = null;
    var yDiff = null;
    var timeDown = null;
    var startEl = null;

    /**
     * Fires swiped event if swipe detected on touchend
     * @param {object} e - browser event object
     * @returns {void}
     */
    function handleTouchEnd(e) {

        // if the user released on a different target, cancel!
        if (startEl !== e.target) return;

        var swipeThreshold = parseInt(getNearestAttribute(startEl, 'data-swipe-threshold', '20'), 10); // default 20px
        var swipeTimeout = parseInt(getNearestAttribute(startEl, 'data-swipe-timeout', '500'), 10);    // default 500ms
        var timeDiff = Date.now() - timeDown;
        var eventType = '';
        var changedTouches = e.changedTouches || e.touches || [];

        if (Math.abs(xDiff) > Math.abs(yDiff)) { // most significant
            if (Math.abs(xDiff) > swipeThreshold && timeDiff < swipeTimeout) {
                if (xDiff > 0) {
                    eventType = 'swiped-left';
                }
                else {
                    eventType = 'swiped-right';
                }
            }
        }
        else if (Math.abs(yDiff) > swipeThreshold && timeDiff < swipeTimeout) {
            if (yDiff > 0) {
                eventType = 'swiped-up';
            }
            else {
                eventType = 'swiped-down';
            }
        }

        if (eventType !== '') {

            var eventData = {
                dir: eventType.replace(/swiped-/, ''),
                xStart: parseInt(xDown, 10),
                xEnd: parseInt((changedTouches[0] || {}).clientX || -1, 10),
                yStart: parseInt(yDown, 10),
                yEnd: parseInt((changedTouches[0] || {}).clientY || -1, 10)
            };

            // fire `swiped` event event on the element that started the swipe
            startEl.dispatchEvent(new CustomEvent('swiped', { bubbles: true, cancelable: true, detail: eventData }));

            // fire `swiped-dir` event on the element that started the swipe
            startEl.dispatchEvent(new CustomEvent(eventType, { bubbles: true, cancelable: true, detail: eventData }));
        }

        // reset values
        xDown = null;
        yDown = null;
        timeDown = null;
    }

    /**
     * Records current location on touchstart event
     * @param {object} e - browser event object
     * @returns {void}
     */
    function handleTouchStart(e) {

        // if the element has data-swipe-ignore="true" we stop listening for swipe events
        if (e.target.getAttribute('data-swipe-ignore') === 'true') return;

        startEl = e.target;

        timeDown = Date.now();
        xDown = e.touches[0].clientX;
        yDown = e.touches[0].clientY;
        xDiff = 0;
        yDiff = 0;
    }

    /**
     * Records location diff in px on touchmove event
     * @param {object} e - browser event object
     * @returns {void}
     */
    function handleTouchMove(e) {

        if (!xDown || !yDown) return;

        var xUp = e.touches[0].clientX;
        var yUp = e.touches[0].clientY;

        xDiff = xDown - xUp;
        yDiff = yDown - yUp;
    }

    /**
     * Gets attribute off HTML element or nearest parent
     * @param {object} el - HTML element to retrieve attribute from
     * @param {string} attributeName - name of the attribute
     * @param {any} defaultValue - default value to return if no match found
     * @returns {any} attribute value or defaultValue
     */
    function getNearestAttribute(el, attributeName, defaultValue) {

        // walk up the dom tree looking for data-action and data-trigger
        while (el && el !== document.documentElement) {

            var attributeValue = el.getAttribute(attributeName);

            if (attributeValue) {
                return attributeValue;
            }

            el = el.parentNode;
        }

        return defaultValue;
    }

}(window, document));

// rate
let voteStar = () => {
    let selector = $(".rateit");
    const url_route = $(".rateit").attr('data-url');
    console.log(selector,url_route);
    if (selector.length > 0) {
        selector.bind('rated', function(e) {
            e.preventDefault();
            let ri = $(this);
            let value = ri.rateit('value');
            let slug = ri.data('slug');
            let voteStart = 0;
            let url = url_route;
            let request = {
                slug: slug,
                star: value,
                voteStart: voteStart
            };
            $.ajax({
                url: url,
                type: 'POST',
                data: request,
                dataType: 'json',
                success: function(data) {
                    if (data.type === 'success') {
                        let container = ri.closest('.allRate');
                        container.find('.avg-rate').text(parseFloat(data.vote.avg).toFixed(1));
                        container.find('.count-rate').text(data.vote.count_vote);
                        selector.addClass('voted');
                        $.Toast('Đánh giá', data.message, data.type,{
                            has_icon:true,
                            has_close_btn:true,
                            stack: true,
                            fullscreen:false,
                            timeout:8000,
                            sticky:false,
                            has_progress:true,
                            rtl:false,
                        });
                    } else {
                        $.Toast('Đánh giá', data.message, data.type,{
                            has_icon:true,
                            has_close_btn:true,
                            stack: true,
                            fullscreen:false,
                            timeout:8000,
                            sticky:false,
                            has_progress:true,
                            rtl:false,
                        });
                    }
                }
            });
        });
    }
  };

const ajax_search = () => {
    $('.seach-header').on('input', function(e){
        clearTimeout(this.delay);
        this.delay = setTimeout(function(){
            $.ajax({
                url: `/tim-kiem-truyen/${$(this).val()}`,
                type: 'get'
            }).done(res => {
                let data = [];
                for(let item of res){
                    let set = {};
                    set.category = item.category.title;
                    set.image = item.image
                    set.title = '<h5 class="text_secondary fs-16 fw-bold">'+item.title+'</h5>'+'<p class="mt-3 fs-14">'+item.descriptions+'</p>';
                    set.url = item.url
                    data.push(set);
                }
                console.log(data);
                $('.ui.search')
                .search({
                    type: 'category',
                    source: data,
                });
            });
        }.bind(this), 800);
        
    })
}

$(document).ready(function(){
    voteStar();
    ajax_search();

    $('.check_search').on('click', function(e){
        e.preventDefault();
        $('.seach-header').click();
    })
});


