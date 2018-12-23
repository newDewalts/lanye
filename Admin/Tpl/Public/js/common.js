
/**
 * ajax 获取子分类数据
 *
 * @param obj   事件元素
 * @param url   请求的url
 * @param id    分类ID
 * @param level 分类层级
 */
function getChildrenCategory(obj, url, id, level)
{
	var menuObj  = $('#cat_id_' + id);
	var isLoad   = menuObj.attr('is-load');
	var status   = menuObj.attr('status');
	var children = menuObj.siblings('tr[parent-id='+id+']');

	// 显示子所有节点
	if (status == 'close') {
		// 修改状态为open
		menuObj.attr('status', 'open');
		// 显示所有子节点
		children.show();
		// 修改状态图标 
		$(obj).find('img').attr('src', '/Admin/Tpl/Public/img/icon-minus.gif');
		
	} else if (status == 'open') {
		// 修改状态为close
		menuObj.attr('status', 'close');
		// 隐藏所有子节点
		children.hide();
		// 修改状态图标
		$(obj).find('img').attr('src', '/Admin/Tpl/Public/img/icon-plus.gif');
	}
	
	if (isLoad == 1) {
		// 已经加载过了
		return false;
	}
	
	// 显示加载等待
	menuObj.after('<tr><td style="padding-left:'+(level*25+10)+'px;"><img src="/Admin/Tpl/Public/img/ajaxLoading.gif"></td></tr>');
	
	$.get(url, {'pid': parseInt(id), 'level': level},  function(ret){
		menuObj.next().remove();
		menuObj.after(ret);
		menuObj.attr('is-load', 1);
	});
}

/**
 * 删除确认提示
 *
 * @param string msg 提示信息
 * @param string url 跳转url
 */
function confirm_redirect(msg, url)
{
    if (confirm(msg)) {
        if(url == undefined) {
            return true;
        }
        window.location = url;
    } else {
        return false;
    }
}

/**
 * 显示缩略图(kindeditor上传后或浏览服务器后被执行)
 *
 * @param url 图片src链接
 * @param thumbId 缩略图img的ID
 * @param deleleBtn 删除缩略图按钮ID 该按钮有一个hasThumb属性(1或0)来判断是否有缩略图
 */
function show_thumb_pic(url, thumbId, deleleBtn)
{
	// 显示缩略图
	$(thumbId).attr('src', url);
	$(deleleBtn).attr('hasThumb', 1);
}

/**
 * 删除缩略图
 *
 * @param btnObj 删除按钮对象(this) 该按钮有一个hasThumb属性(1或0)来判断是否有缩略图
 * @param thumbId 缩略图img的ID
 * @param thumbInputID 显示缩略图路径的input元素ID
 */
/*
function delete_thumb(btnObj, thumbId, thumbInputID)
{
	// 有缩略图
	if ($(btnObj).attr('hasThumb') == 1) {
		$(thumbId).attr('src', '/Admin/Tpl/Public/img/default_thumb.jpg');
		$(thumbInputID).val('');
	}
}
*/

/**
 * 删除缩略图
 *
 * @param btnObj 删除按钮对象(this) 该按钮有一个hasThumb属性(1或0)来判断是否有缩略图
 * @param thumbId 缩略图img的ID
 * @param thumbInputID 显示缩略图路径的input元素ID
 * @param url ajax请求的地址
 */
function delete_thumb(btnObj, thumbId, thumbInputID, url)
{
	// 有缩略图
	if ($(btnObj).attr('hasThumb') == 1) {
		
		$(btnObj).after('<img src="/Admin/Tpl/Public/img/loading_small.gif">');
		
		$.get(url, {path: $(thumbId).attr('src')}, function(ret){
			if (ret.error == 0) {
				$(btnObj).next('img').remove();
				$(thumbId).attr('src', '/Admin/Tpl/Public/img/default_thumb.jpg');
				$(thumbInputID).val('');
				$(btnObj).attr('hasThumb', 0);
			} else {
				alert(ret.info);
			}
		}, 'JSON');
	}
}