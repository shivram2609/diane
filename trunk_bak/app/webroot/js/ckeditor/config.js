/*
Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	// Define changes to default configuration here. For example:
				// config.language = 'fr';
				// config.uiColor = '#AADC6E';
				//config.removePlugins = 'Image';
				//config.toolbar = 'Basic';
				//config.resize_enabled = false;
				config.resize_maxWidth = 1130;
				config.resize_minWidth = 1130;
				config.resize_maxHeight = 500;
				config.resize_minHeight = 500;
				config.docType = '<!DOCTYPE html>';
				config.toolbar_MyToolbar =
				[
					{ name: 'document', items : [ 'NewPage','Preview' ] },
					{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
					{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','Scayt' ] },
					{ name: 'insert', items : ['Table','HorizontalRule','Smiley','SpecialChar','PageBreak'
							 ,'Iframe' ] },
							'/',
					{ name: 'styles', items : [ 'Styles','Format' ] },
					{ name: 'basicstyles', items : [ 'Bold','Italic','Strike','-','RemoveFormat' ] },
					{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote' ] },
					{ name: 'links', items : [ 'Link','Unlink','Anchor' ] },
					{ name: 'tools', items : [ 'Maximize','-','About' ] }
				];
				config.toolbar_Basic =
				[
					['Bold', 'Italic', '-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink','-','Outdent','Indent','-','Blockquote']
				];
				config.toolbar_Basiclec =
				[
					[]
				];
			};

