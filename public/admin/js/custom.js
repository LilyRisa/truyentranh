
$(document).ready(function () {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    $('.tags').tagify();
});


$(document).on('click', '.ajax-login', function (e) {
    e.preventDefault();
    let form = $(this).closest('form');
    let url = form.attr('action');
    let data = form.serialize();
    if(data.indexOf('=&') > -1 || data.substr(data.length - 1) == '='){
        showToastr('error','Form không được để trống!');
        return 0;
     }
    $('#loading_login').attr('style', '');
    $.ajax({
        url: url,
        data: data,
        type: 'POST',
        dataType: 'json',
    }).done( function (res) {
        $('#loading_login').attr('style', 'display:none');
        if (res.status === 'success'){
            window.location.href = '/admin/home';
        } else {
            showToastr('error','Tài khoản hoặc mật khẩu không đúng!');
            form[0].reset();
            return false;
        }
    }).fail(e => {
        $('#loading_login').attr('style', 'display:none');
        showToastr('error', 'Lỗi');
    });
});

$(document).on('keypress', 'input[name="password"]',function(e) {
    if(e.which === 13) {
        $('.ajax-login').trigger('click');
    }
});

$(document).on('keypress', '.customValidity', function (e) {
    $(this).get(0).setCustomValidity("");
});

function checkEmptyCustomValidity() {
    $('.customValidity').each(function () {
        if (!$(this).val()) {
            $(this).get(0).setCustomValidity("Không được để trống!");
            $(this).get(0).reportValidity();
            return false;
        }
    });
    return true;
}

$(document).on('click', '.btn-change-password', function (e) {
    e.preventDefault();
    if (!checkEmptyCustomValidity()) return;
    let input_old_password = $('#changePassword input[name="old_password"]');
    let input_new_password = $('#changePassword input[name="new_password"]');
    let input_re_password = $('#changePassword input[name="re_password"]');
    let old_password = input_old_password.val();
    let new_password = input_new_password.val();
    let re_password = input_re_password.val();
    if (re_password !== new_password) {
        input_re_password.get(0).setCustomValidity("Mật khẩu nhập lại chưa đúng!");
        input_re_password.get(0).reportValidity();
        return false;
    }
    $.ajax({
        url: '/admin/ajax/changePassword',
        data: {
            old_password: old_password,
            new_password: new_password
        },
        type: 'POST',
        dataType: 'json',
        success: function (res) {
            if (res.status === 'success'){
                $('#changePassword').modal('hide');
                showToastr('success', res.message);
            } else {
                input_old_password.get(0).setCustomValidity("Mật khẩu cũ không đúng!");
                input_old_password.get(0).reportValidity();
            }
        }
    })
});

function upload_file(mode,control){
    let open_url = 'https://thichdammy.com/admin/libraries/elfinder/file-elfinder.php?mode='+mode+'&control='+control;
    window.open(open_url,'_blank',"location=0,left=200,width=800,height=500");
    return false;
}

if (document.getElementById('select-multi-category')) {
    let data = {};
    let post_id = $('#select-multi-category').data('post-id');
    let story_id = $('#select-multi-category').data('story-id');
    if(typeof post_id !== 'undefined'){
        data.post_id = post_id;
    }else if(typeof story_id !== 'undefined'){
        data.story_id = story_id;
    }
    $.ajax({
        url: '/admin/ajax/loadCategory',
        type: 'POST',
        data: data,
        dataType: "json",
        success: function(data) {
            if (data.list_category) {
                let options = data.list_category;
                let select = document.getElementById('select-multi-category');
                new coreui.MultiSelect(select, {
                    multiple: true,
                    selectionType: 'tags',
                    search: true,
                    options: options
                });
            }
            if (data.category_selected) {
                data.category_selected.forEach((item) => {
                    $('#select-multi-category').closest('.form-group').find('.c-multi-select-option[data-value="'+item+'"]').trigger('click');
                });
            }
        }
    });

    $('form').submit(function() {
        let container = $('#select-multi-category').parent();
        $(container).find('.c-multi-select-selection .c-multi-select-tag').each(function () {
            let id = $(this).data('value');
            $(this).append('<input type="hidden" name="category[]" value="'+id+'">');
        });
        return true;
    });
}

if (document.getElementById('select-multi-category-video')) {
    let video_id = $('#select-multi-category').data('video-id');
    $.ajax({
        url: '/admin/ajax/loadCategory',
        type: 'POST',
        data: {
            video_id: video_id
        },
        dataType: "json",
        success: function(data) {
            if (data.list_category) {
                let options = data.list_category;
                let select = document.getElementById('select-multi-category-video');
                new coreui.MultiSelect(select, {
                    multiple: true,
                    selectionType: 'tags',
                    search: true,
                    options: options
                });
            }
            if (data.category_selected) {
                data.category_selected.forEach((item) => {
                    $('#select-multi-category').closest('.form-group').find('.c-multi-select-option[data-value="'+item+'"]').trigger('click');
                });
            }
        }
    });

    $('form').submit(function() {
        let container = $('#select-multi-category-video').parent();
        $(container).find('.c-multi-select-selection .c-multi-select-tag').each(function () {
            let id = $(this).data('value');
            $(this).append('<input type="hidden" name="category[]" value="'+id+'">');
        });
        return true;
    });
}

if (document.getElementById('select-multi-tag-video')) {
    let video_id = $('#select-multi-tag').data('video-id');
    $.ajax({
        url: '/admin/ajax/loadTag',
        type: 'POST',
        data: {
            video_id: video_id
        },
        dataType: "json",
        success: function(data) {
            if (data.list_tag) {
                let options = data.list_tag;
                let select = document.getElementById('select-multi-tag-video');
                new coreui.MultiSelect(select, {
                    multiple: true,
                    selectionType: 'tags',
                    search: true,
                    options: options
                });
            }
            if (data.tag_selected) {
                data.tag_selected.forEach((item) => {
                    $('.c-multi-select-option[data-value="'+item+'"]').trigger('click');
                });
            }
        }
    });

    $('form').submit(function() {
        let container = $('#select-multi-tag-video').parent();
        $(container).find('.c-multi-select-selection .c-multi-select-tag').each(function () {
            let id = $(this).data('value');
            $(this).append('<input type="hidden" name="tag[]" value="'+id+'">');
        });
        return true;
    });
}

if (document.getElementById('select-multi-tag')) {
    let data = {};
    let post_id = $('#select-multi-category').data('post-id');
    let story_id = $('#select-multi-category').data('story-id');
    if(typeof post_id !== 'undefined'){
        data.post_id = post_id;
    }else if(typeof story_id !== 'undefined'){
        data.story_id = story_id;
    }
    $.ajax({
        url: '/admin/ajax/loadTag',
        type: 'POST',
        data: data,
        dataType: "json",
        success: function(data) {
            if (data.list_tag) {
                let options = data.list_tag;
                let select = document.getElementById('select-multi-tag');
                new coreui.MultiSelect(select, {
                    multiple: true,
                    selectionType: 'tags',
                    search: true,
                    options: options
                });
            }
            if (data.tag_selected) {
                data.tag_selected.forEach((item) => {
                    $('.c-multi-select-option[data-value="'+item+'"]').trigger('click');
                });
            }
        }
    });

    $('form').submit(function() {
        let container = $('#select-multi-tag').parent();
        $(container).find('.c-multi-select-selection .c-multi-select-tag').each(function () {
            let id = $(this).data('value');
            $(this).append('<input type="hidden" name="tag[]" value="'+id+'">');
        });
        return true;
    });
}

if (document.getElementById('select-multi-category-author')) {
    let author_id = $('#select-multi-category-author').data('author-id');
    $.ajax({
        url: '/admin/ajax/loadCategoryAuthor',
        type: 'POST',
        data: {
            author_id: author_id
        },
        dataType: "json",
        success: function(data) {
            if (data.categories) {
                let options = data.categories;
                let select = document.getElementById('select-multi-category-author');
                new coreui.MultiSelect(select, {
                    multiple: true,
                    selectionType: 'tags',
                    search: true,
                    options: options
                });
            }
            if (data.categories_selected) {
                data.categories_selected.forEach((item) => {
                    $('#select-multi-category-author').closest('.form-group').find('.c-multi-select-option[data-value="'+item+'"]').trigger('click');
                });
            }
        }
    });

    $('form').submit(function() {
        let container = $('#select-multi-category-author').parent();
        $(container).find('.c-multi-select-selection .c-multi-select-tag').each(function () {
            let id = $(this).data('value');
            $(this).append('<input type="hidden" name="categories[]" value="'+id+'">');
        });
        return true;
    });
}

$(document).ready(function () {
    if (typeof $('#nestable')[0] != 'undefined') {
        var container = $('#nestable');
        container.nestable({
            group: 1,
            maxDepth: 2
        }).change(function () {
            updateOutput(container);
        });
        $('.category_select').click(function(){
            var category = $('select[name=category_id]');
            var option = $('option:selected', category);
            var url = $(option).data('url');
            var title = $(option).data('title');
            console.log(title);
            title = title.replace(/-/g, '');
            appendEditMenuItem(container, title, url);
            updateOutput(container);
            toggleEditMenuItem();
            editMenuItem();
            deleteMenuItem();
        });
        $('.link_select').click(function(){
            var url = $('input[name=custom_link]').val();
            appendEditMenuItem(container, url, '#');
            updateOutput(container);
            toggleEditMenuItem();
            editMenuItem();
            deleteMenuItem();
        });
        var data = $('input[name=data]').val();
        if (data !== ''){
            listify(container, data);
            toggleEditMenuItem();
            editMenuItem();
            deleteMenuItem();
        }
    }
})
function toggleEditMenuItem() {
    $(document).on('click', '.nestleeditd', function () {
        $(this).parent().siblings('div.menublock').toggleClass('d-none');
    });
}
function editMenuItem() {
    $('.apply_item').on('click',function () {
        var container = $(this).closest('li.dd-item');
        var name = container.find('.name_item').first().val();
        var url = container.find('.link_item').first().val();
        container.data('name', name);
        container.data('url', url);
        container.find('.dd-handle').first().text(name);
        updateOutput($('#nestable'));
        container.find('.nestleeditd').first().trigger('click');
    });
}
function deleteMenuItem() {
    $('.nestledeletedd').on('click',function (e) {
        e.preventDefault();
        var item;
        item = $(this).closest('li.dd-item');
        if (confirm('Bạn có chắc chắn xóa?')) {
            item.remove();
        }
        /*$('#smallModal').modal('show');
        $('.confirm_yes').click(function() {
            item.remove();
            $('#smallModal').modal('hide');
        })*/
        updateOutput($('#nestable'));
    });
}
function appendEditMenuItem(container, title, url) {
    var item = "<li class='dd-item' data-name='' data-url=''>\n" +
        "    <div class='dd-handle'></div>\n" +
        "    <div class='action-item'>\n" +
        "        <span class='nestleeditd'>\n" +
        "            <svg class='c-icon'>\n" +
        "                <use xlink:href='/admin/images/icon-svg/free.svg#cil-pencil'></use>\n" +
        "            </svg>\n" +
        "        </span>\n" +
        "        <span class='nestledeletedd'>\n" +
        "            <svg class='c-icon'>\n" +
        "                <use xlink:href='/admin/images/icon-svg/free.svg#cil-trash'></use>\n" +
        "            </svg>\n" +
        "        </span>\n" +
        "    </div>\n" +
        "    <div class='menublock d-none'>\n" +
        "        <input type='text' class='form-control name_item' value='' placeholder='Name'>\n" +
        "        <input type='text' class='form-control link_item' value='' placeholder='Link'>\n" +
        "        <input type='button' class='mt-1 btn btn-theme apply_item border' value='Apply'>\n" +
        "    </div>\n" +
        "</li>";
    item = $.parseHTML(item);
    $(item).data('name', title);
    $(item).data('url', url);
    $(item).find('.dd-handle').text(title);
    $(item).find('.name_item').val(title);
    $(item).find('.link_item').val(url);
    container.find('.dd-list').first().append(item);
    return item;
}
function updateOutput(e) {
    var list   = e.length ? e : $(e.target);
    if (window.JSON) {
        var data = window.JSON.stringify(list.nestable('serialize'));
        $('input[name=data]').val(data);
    }
}
function listify(container, strarr) {
    var obj = JSON.parse(strarr);
    if (!obj.length) obj = [obj];
    $.each(obj, function(i, v) {
        if (typeof v == 'object') {
            var name = v.name;
            var url = v.url;
            var parent = appendEditMenuItem(container,name,url);
            if (!!v.children){
                var div = "<ol class='dd-list'></ol>";
                $(parent).append(div);
                $.each(v.children, function(key, item) {
                    listify($(parent), JSON.stringify(item));
                });
            }
        }
    });
}

$(document).on('change', '.sl-type-post', function () {
    let url = $(this).val();
    window.location.href = url;
});

$('.save-draft').on('click', function() {
    $('select[name=status]').val('0');
    $('button[type=submit]').trigger('click');
})

// convert title to slug

$('input[name=meta_title]').stringToSlug({
    getPut: 'input[name=slug]',
    space: '-',
});



// custom
// $('#lbl_img').on('click', function (){
//     let input = document.createElement('input');
//     input.type = 'file';
  
//     input.onchange = e => { 
//       $('#progress-wrp').show();
//       let file = e.target.files[0];
//       let upload = new uploadImg(file);
//       upload.setProgressBar('#progress-wrp');
//       console.log(upload);
//       upload.doUpload('/admin/upload_image').then((data) => {
//         $('#lbl_img').on('load', function(){
//             $("#progress-wrp .progress-bar").css("width", "100%");
//             $("#progress-wrp .status").text("100%");
//             setTimeout(()=>{
//                 $('#progress-wrp').hide("slow");
//             },2000)
            
//         }).attr('src', '/img/thumb/'+ data.data);
//         $('#hd_img').val(data.data);
//       }).catch(e => {
//         console.log(e);
//       });
//     }
  
//     input.click();
//   });

$('#yes_del_cache').on('click', function(){
    $.ajax({
        url: '/admin/clear-cache',
        type: 'get',
    }).done((e) => {
        $('#cacheDelete').modal('hide');
        alert(e);
    }).fail((e) => {
        $('#cacheDelete').modal('hide');
        alert('Lỗi!');
    });
});

$(function() {
    $('.datetimes').daterangepicker({
      timePicker: true,
      startDate: moment().startOf('hour'),
      endDate: moment().endOf('hour'),
      locale: {
        format: 'YYYY-MM-DD HH:mm:ss'
      },
      ranges: {
        'Hôm nay': [moment(), moment()],
        'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        '7 ngày qua': [moment().subtract(6, 'days'), moment()],
        '30 ngày qua': [moment().subtract(29, 'days'), moment()],
        'tháng này': [moment().startOf('month'), moment().endOf('month')],
        'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
     }
    });

    if($('.datetimes').data('date') != '' && $('.datetimes').data('date') != null){
        let data = $('.datetimes').data('date');
        data = data.split(" - ");
        console.log(data);
        $('.datetimes').daterangepicker({
            timePicker: true,
            startDate: moment(data[0]),
            endDate: moment(data[1]),
            locale: {
              format: 'YYYY-MM-DD HH:mm:ss'
            },
            ranges: {
              'Hôm nay': [moment(), moment()],
              'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
              '7 ngày qua': [moment().subtract(6, 'days'), moment()],
              '30 ngày qua': [moment().subtract(29, 'days'), moment()],
              'tháng này': [moment().startOf('month'), moment().endOf('month')],
              'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
           }
          });

    }
  });

 $('#reset_form').on('click', function(e){
    e.preventDefault();
    var form = $(this).closest('form').get(0);
    form.reset();
    $(form).find('select').each(function(i, v) {
        $(v).trigger('chosen:updated');
    });
    console.log(form);
 })


 $('.short-url').on('submit', function(e){
    e.preventDefault();
    let data = {
        url: $('#short_url_link').val()
    }
    $.ajax({
        url: '/admin/ajax-short-url',
        type:'post',
        data: data,
    }).done(res => {
        $('#short_url_return').val('https://fthichdammy.com/short.fx?url='+res.url_new);
        $('#short_url_return').show();
    }).fail(e=>{
        alert('Lỗi hệ thống');
    })

 });
 
 const googleIndex = (status, obj) => {
    console.log(status);
    $(obj).find('img').attr('style', '');
    let url = $('#url').val();
    if(url == '' || url == null || typeof url === 'undefined'){
        console.log('url empty');
        $(obj).find('img').attr('style', 'display:none');
        showToastr('error', 'Nhập url');
        return 0;
    }
    $.ajax({
        url: '/admin/ajax/google_index',
        type: 'POST',
        data: {
            url : url,
            action : status
        }
    }).done(resp => {
        $(obj).find('img').attr('style', 'display:none');
        if(resp.status){
            showToastr('success', resp.mess);
        }else{
            showToastr('error', resp.mess);
        }
    }).fail(e => {
        $(obj).find('img').attr('style', 'display:none');
        showToastr('error', 'lỗi mạng');
    });
}

 $('.home_feature').on('click', function(e){
    e.preventDefault();
    let id = $(this).data('id');

    var thas = $(this);

    $.ajax({
        url: '/admin/ajax/add_feature_home',
        type: 'post',
        data: {
            id : id
        }
    }).done(resp => {
        if(resp.status){
            showToastr('success', resp.mess);
            $(thas).attr('style', 'color: yellow;');
            $('.star_home').attr('style','');
            $('.star_home').attr('class','home_feature');
            $(thas).attr('class','home_feature star_home');
        }else{
            showToastr('error', resp.mess);
        }
        
    }).fail(e => {
        showToastr('error', 'Lỗi hệ thống');
    });
 });


 function user_traffic_realtime(){
    $.ajax({
        url: '/admin/get_user_now',
        type : 'get'
    }).done(resp => {
        if(resp != null){
            let tmp = '<div>';
            resp.forEach((v, i) => {
                tmp += `<div><span>${v.country}: </span> ${v.count}</div>`
            })
            tmp += '</div>'
            $('#user_traffic_realtime').html(tmp);
        }
        
    });
 }

 function user_traffic(){
    $.ajax({
        url: '/admin/get_user_count',
        type : 'get'
    }).done(resp => {
        $('#user_traffic').text(resp.data);
    });
 }

 setInterval(() => {
    user_traffic_realtime();
    user_traffic();
 }, 30 * 1000);

 $('#delcache_cloudflare').on('click', function(){
    $.ajax({
        url: '/admin/cloudflare_cache_remove',
        type: 'get',
    }).done((e) => {
        if(e.status){
            alert('Thành công');
        }else{
            alert('Lỗi');
        }
        $('#clouflare_remove').modal('hide');
        
        // alert(e);
    }).fail((e) => {
        $('#clouflare_remove').modal('hide');
        alert('Lỗi!');
    });
});
 

