
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
	
});

