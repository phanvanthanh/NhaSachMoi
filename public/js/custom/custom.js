
$(document).ready(function(){
    // alert
    $("#alert").hide();
    /*
    jQuery('#alert').attr('class','alert alert-danger').children('span').text('Lỗi! Cập nhật giỏ hàng không thành công!');
    jQuery('#alert').show('slow').delay(3000).hide('slow');
    */    

    tableResponsive();

    jQuery('.modal-cap-nhat-quyen').on('click', function(){
        var permission_id=jQuery(this).attr('permission-id');
        var permission_data=jQuery(this).attr('permission-data');
        jQuery('#modal-cap-nhat-quyen').find('#permission-id').val(permission_id);
        jQuery('#modal-cap-nhat-quyen').find('#permission-name').val(permission_data);
        jQuery('#modal-cap-nhat-quyen').modal();
    });

    jQuery('.checkbox-is-check').on('click', function(){
        if(jQuery(this).find('input[type="checkbox"]').prop('checked')){
            jQuery(this).find('input[type="checkbox"]').removeAttr('checked');
            var parent=jQuery(this).find('input[type="checkbox"]').val();
            unCheckChild(parent);
        }
        else{
            jQuery(this).find('input[type="checkbox"]').prop('checked', true);
            var parent_name=jQuery(this).find('input[type="checkbox"]').prop('name');
            var array_parent=parent_name.split("_");
            var parent=array_parent[0];
            checkParent(parent);
        }
    });

    // sử dụng trong view them san phẩm
    jQuery('#loai_gia').on('click', function(){
        var checked=jQuery(this).is(':checked');
        if(checked){
            jQuery('.gia-bia').removeClass('hidden-xs hidden-sm hidden-md hidden-lg');
            jQuery('.gia-nhap').addClass('hidden-xs hidden-sm hidden-md hidden-lg');
        }
        else{
            jQuery('.gia-nhap').removeClass('hidden-xs hidden-sm hidden-md hidden-lg');
            jQuery('.gia-bia').addClass('hidden-xs hidden-sm hidden-md hidden-lg');
        }
    });

    //Hien thi hinh anh sau khi chon    
    jQuery('#upload_img').change( function(event) {
        var val = jQuery("#upload_img").val().toLowerCase();
        if (!val.match(/(?:gif|jpg|png|bmp)$/)) {
            jQuery("#img").attr('src','');
            jQuery('#img').attr('class','hidden');
            jQuery('#divImg').html('<span>Vui lòng chọn tập tin hình ảnh</span>');
        }else{
            jQuery('#img').attr('class','img-circle');   
            var tmppath = URL.createObjectURL(event.target.files[0]);
            jQuery("#img").fadeIn("fast").attr('src',tmppath);
        }
    });

    // attach table filter plugin to inputs
    $('[data-action="filter"]').filterTable();
    $('[data-action="filter-2"]').filterTable();

    $('.date-time').datepicker({
        format: "dd-mm-yyyy"
    });
});

