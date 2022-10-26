
import $ from 'jquery';

window.$ = window.jQuery = $;


const FUNC = {
    ajax_load_more: function() {
        $(document).on('click', '.load-more', function (e) {
            e.preventDefault();
            // let page = $(this).attr('data-page');
            let url = $(this).data('url');
            let category_id = typeof $(this).data('category') === 'undefined' ? '' : ($(this).data('category'))+'/';
            var page = $(this).attr('data-page');
            console.log(page);
            page = parseInt(page) + 1;
            var that = this;
            // if (page == null) page = 2;
            $.ajax({
                type: 'get',
                url: '/'+url+'/'+category_id + page,
                dataType: 'html',
                data: {
                    page: page,
                },
                success: function (res) {
                    let selector_show_content = '#ajax_content';
                    if(res != null && res != ''){
                      console.log('true');
                      // page = page+1;
                      console.log(page);
                        // let resultFind = $(res).find('#ajax_content').html();
                        $(selector_show_content).append(res);
                        $(that).attr('data-page', page);
                    }else{
                      console.log('false');
                        $(selector_show_content).append(`<p class="text-center" id="empty_data" style="display: none">Hết dữ liệu</p>`);
                        $('#empty_data').show().fadeOut();
                        setTimeout(()=>{
                            $('#empty_data').hide();
                        },3000)
                    }
                    
                }
            })
        })
    },
    init: function () {
        $(document).ready(function(){
            FUNC.ajax_load_more();
            FUNC.post_table();
            FUNC.contact();
        });
        
    },
    post_table: ()=>{
        let container = $("#table-of-content");
        if (container.length > 0) {
            let header = container.find(':header:not(h1,h4,h5,h6,h3.title-related)');
            if (header.length > 0) {
                let trick = '<div class="bg-grey32 p-3 my-2 muc-luc"> <h4 class="text-red1 text-uppercase fs-18 fw-normal">Nội dung chính </h4> <ul class="nav flex-column">';
                $.each(header, function(k, i) {
                    let id = 'trick' + k;
                    let title = $(i).text();
                    if (title !== '') {
                        let patt = new RegExp('\\d*\\.\\s', 'mi');
                        title.replace(patt, '');
                        $(i).attr('id', id);
                        trick += '<li class="item-muc-luc"><a href="#' + id + '" rel="nofollow" class="text-news-link font-9375rem">' + title + '</a></li>';
                    }
                });
                trick += '</ul></div>';
                container.prepend(trick);
            }
        }
        container.on('click', 'a', function() {
            let hash = $(this).attr('href');
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 1500, 'swing');
        })
    },
    contact : () => {
      $('#contact-form').on('submit', (e) => {
          e.preventDefault();
          var $input = $('#contact-form :input');
          var $textarea = $('#contact-form textarea');
          var values = {};
          $input.each(function() {
              values[this.name] = $(this).val();
          });
          $textarea.each(function() {
              values[this.name] = $(this).val();
          });
  
          console.log(values);
  
          $.ajax({
            url:"/contact-form",
            type: 'post',
            data: values
          }).done(resp => {
            // alert(resp);
            console.log(resp);
          }).fail(e => {
            alert('Lỗi hệ thống!');
          })
  
      });
    }
  };

export default FUNC;