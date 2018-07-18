/*******************************************************************************
* KindEditor - WYSIWYG HTML Editor for Internet
* Copyright (C) 2006-2011 kindsoft.net
*
* @author Roddy <luolonghao@gmail.com>
* @site http://www.kindsoft.net/
* @licence http://www.kindsoft.net/license.php
*******************************************************************************/

KindEditor.plugin('tao', function(K) {
	var self = this, name = 'tao';
	var html = [
		'<div style="padding:20px;">',
		//tabs
		'<div class="tabs"></div>',
		
		'<div class="tab1" style="display:none;">',
		//url
		'<div class="ke-dialog-row">',
		'<label for="data-itemid" style="width:60px;">' + self.lang('tao_itemid') + '</label>',
		'<input type="text" id="data-itemid" class="ke-input-text" name="data-itemid" value="" style="width:200px;" /> &nbsp;',
		'</div>',
		'<div class="ke-dialog-row">',
		'<label for="data-itemid-text" style="width:60px;">' + self.lang('tao_itemid_text') + '</label>',
		'<input type="text" id="data-itemid-text" class="ke-input-text" name="data-itemid-text" value="" style="width:200px;" /> &nbsp;',
		'</div>',
		//align
		'<div class="ke-dialog-row">',
		'<label style="width:60px;">' + self.lang('tao_itemid_tmpl') + '</label>',
		'<input type="radio" name="data-tmpl" class="ke-inline-block" value="" />文字链接 ',
		' <input type="radio" name="data-tmpl" class="ke-inline-block" value="230x312" checked="checked" />230x312 ',
		' <input type="radio" name="data-tmpl" class="ke-inline-block" value="290x380" />290x380 ',
		' <input type="radio" name="data-tmpl" class="ke-inline-block" value="350x100" />350x100 ',
		' <input type="radio" name="data-tmpl" class="ke-inline-block" value="628x100" />628x100 ',
		'</div>',
		'<div class="ke-dialog-row">',
		'<label style="width:60px;">' + self.lang('tao_itemid_jump') + '</label>',
		'<input type="radio" name="data-rd" class="ke-inline-block" value="1" checked="checked" />'+self.lang('tao_itemid_jump_name1'),
		' <input type="radio" name="data-rd" class="ke-inline-block" value="2" />'+self.lang('tao_itemid_jump_name2'),
		'</div>',
		'<div class="ke-dialog-row">',
		'<label style="width:60px;">' + self.lang('tao_itemid_style') + '</label>',
		'<input type="radio" name="data-style" class="ke-inline-block" value="1" />'+self.lang('tao_itemid_style_name1'),
		' <input type="radio" name="data-style" class="ke-inline-block" value="2" checked="checked" />'+self.lang('tao_itemid_style_name2'),
		'</div>',
		'<div><a href="http://www.tianxianet.com/help/674.html" target="_blank">' + self.lang('tao_plugins_help') + '</a></div>',
		'</div>',
		
		'<div class="tab2" style="display:none;">',
		'<div class="ke-dialog-row">',
		'<label for="data-itemid" style="width:60px;">' + self.lang('tao_keyword') + '</label>',
		'<input type="text" id="data-keyword" class="ke-input-text" name="data-keyword" value="" style="width:200px;" /> &nbsp;',
		'</div>',
		'<div class="ke-dialog-row">',
		'<label for="data-keyword-text" style="width:60px;">' + self.lang('tao_itemid_text') + '</label>',
		'<input type="text" id="data-keyword-text" class="ke-input-text" name="data-keyword-text" value="" style="width:200px;" /> &nbsp;',
		'</div>',
		//align
		'<div class="ke-dialog-row">',
		'<label style="width:60px;">' + self.lang('tao_itemid_tmpl') + '</label>',
		'<input type="radio" name="data-tmpl-k" class="ke-inline-block" value="" />文字链接 ',
		' <input type="radio" name="data-tmpl-k" class="ke-inline-block" value="290x380" checked="checked" />290x380 ',
		' <input type="radio" name="data-tmpl-k" class="ke-inline-block" value="350x170" />350x170 ',
		' <input type="radio" name="data-tmpl-k" class="ke-inline-block" value="350x270" />350x270 ',
		' <input type="radio" name="data-tmpl-k" class="ke-inline-block" value="628x170" />628x170 ',
		' <input type="radio" name="data-tmpl-k" class="ke-inline-block" value="628x270" />628x270 ',
		'</div>',
		'<div class="ke-dialog-row">',
		'<label style="width:60px;">' + self.lang('tao_itemid_jump') + '</label>',
		'<input type="radio" name="data-rd-k" class="ke-inline-block" value="1" checked="checked" />'+self.lang('tao_itemid_jump_name1'),
		' <input type="radio" name="data-rd-k" class="ke-inline-block" value="2" />'+self.lang('tao_itemid_jump_name2'),
		'</div>',
		'<div class="ke-dialog-row">',
		'<label style="width:60px;">' + self.lang('tao_itemid_style') + '</label>',
		'<input type="radio" name="data-style-k" class="ke-inline-block" value="1"  />'+self.lang('tao_itemid_style_name1'),
		' <input type="radio" name="data-style-k" class="ke-inline-block" value="2" checked="checked" />'+self.lang('tao_itemid_style_name2'),
		'</div>',
		'<div><a href="http://www.tianxianet.com/help/674.html" target="_blank">' + self.lang('tao_plugins_help') + '</a></div>',
		'</div>',
		
		'</div>'
	].join('');
	
	self.clickToolbar(name, function() {
		var dialog = self.createDialog({
			name : name,
			body : html,
			width : 550,
			height : 330,
			title : self.lang('tao'),
			yesBtn : {
				name : self.lang('yes'),
				click : function(e) {
					if(tabs.selectedIndex == 0)
					{
						if( ! $('input[name=data-itemid]').val())
						{
							alert(self.lang('tao_vd_itemid'));
							return;
						}
						if ( ! /^\d*$/.test($('input[name=data-itemid]').val())) {
							alert(self.lang('tao_vd_itemid_num'));
							return;
						}
						if( ! $('input[name=data-itemid-text]').val())
						{
							alert(self.lang('tao_vd_itemid_text'));
							return;
						}
						var istr = '<a rel="nofollow" href="javascript:void(0)" data-type="0" biz-itemid="'+$('input[name=data-itemid]').val()+'" data-rd="'+$('input[name=data-rd]:checked').val()+'" data-style="'+$('input[name=data-style]:checked').val()+'" data-tmpl="'+$('input[name=data-tmpl]:checked').val()+'" target="_blank">'+$('input[name=data-itemid-text]').val()+'</a>';
					}
					else
					{
						if( ! $('input[name=data-keyword]').val())
						{
							alert(self.lang('tao_vd_keyword_text'));
							return;
						}
						if( ! $('input[name=data-keyword-text]').val())
						{
							alert(self.lang('tao_vd_itemid_text'));
							return;
						}
						var istr = '<a rel="nofollow" href="javascript:void(0)" data-type="2" biz-keyword="'+$('input[name=data-keyword]').val()+'" data-rd="'+$('input[name=data-rd-k]:checked').val()+'" data-style="'+$('input[name=data-style-k]:checked').val()+'" data-tmpl="'+$('input[name=data-tmpl-k]:checked').val()+'" target="_blank">'+$('input[name=data-keyword-text]').val()+'</a>';
					}
					self.insertHtml(istr).hideDialog().focus();
				}
			}
		});
		var div = dialog.div;
		
		var tabs = K.tabs({
			src : K('.tabs', div),
			afterSelect : function(i) {}
		});
		tabs.add({
			title : self.lang('tao_dp'),
			panel : K('.tab1', div)
		});
		tabs.add({
			title : self.lang('tao_ss'),
			panel : K('.tab2', div)
		});
		tabs.select(0);
	});
});
