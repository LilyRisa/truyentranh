import $ from 'jquery';
window.$ = window.jQuery = $;

import bootstrap from 'bootstrap'
import './rateit';
import './toastr';
import './search';
import './slider';

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
                    fullTextSearch: true
                });
            });
        }.bind(this), 300);
        
    })
}

function setCookie(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    let expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
        c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
        }
    }
    return null;
    }

const change_status_dom_story = (status) => {
    if(status){
        $('.follow-story').attr('data-status', 1);
        $('.follow-story').attr('class', 'btn bg-red1 border-0 text-white follow-story');
        // $('.follow-story').find('i').attr('class', 'icon-history text-white');
        $('.follow-story').html('<i class="icon-history text-white"></i> Bỏ theo dõi');
    }else{
        $('.follow-story').attr('data-status', 0);
        $('.follow-story').attr('class', 'btn bg-green1 border-0 text-white follow-story');
        // $('.follow-story').find('i').attr('class', 'icon-heart text-white');
        $('.follow-story').html('<i class="icon-heart text-white"></i> Thêm vào tủ');
    }
}

const follow_story = () => {
    let data_new = getCookie('story_follow');
    let id_new = $('.follow-story').attr('data-story');
    if(typeof id_new === 'undefined' || id_new == null || id_new == ''){
        return 0;
    }
    id_new = parseInt(id_new);
    if(data_new){
        data_new = JSON.parse(data_new);
        if(data_new.includes(id_new)){
            change_status_dom_story(true);
        }
    }
}

$(document).ready(function(){
    voteStar();
    ajax_search();
    follow_story();
    $('.check_search').on('click', function(e){
        e.preventDefault();
        $('.seach-header').focus();
    })

    // slide
    $('.follow').lightSlider({
        item:4,
        loop:false,
        slideMove:2,
        easing: 'cubic-bezier(0.25, 0, 0.25, 1)',
        speed:600,
        responsive : [
            {
                breakpoint:800,
                settings: {
                    item:3,
                    slideMove:1,
                    slideMargin:6,
                  }
            },
            {
                breakpoint:480,
                settings: {
                    item:2,
                    slideMove:1
                  }
            }
        ]
    });  

    $('.follow-story').on('click', function(e){
        e.preventDefault();

        let data = getCookie('story_follow');
        let id = $(this).attr('data-story');
        id = parseInt(id);
        console.log(data);
        console.log(id);
        
        if(!data){
            data = [];
            change_status_dom_story(true);
            data.push(id);
            data = JSON.stringify(data);
            setCookie('story_follow',data,5);
        }else{
            data = JSON.parse(data);
            if(data.includes(id)){
                change_status_dom_story(false);
                let index = data.indexOf(id);
                delete data[index];
                data = data.filter(function (el) {
                    return el != null;
                  });
                data = JSON.stringify(data);
                setCookie('story_follow',data,5);
            }else{
                change_status_dom_story(true);
                data.push(id);
                data = JSON.stringify(data);
                setCookie('story_follow',data,5);
            }
        }
        
    })
});


