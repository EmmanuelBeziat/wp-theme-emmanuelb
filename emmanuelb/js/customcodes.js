(function() {
    tinymce.create('tinymce.plugins.News', {
        init: function(ed, url) {
            ed.addCommand('xml', function() {
                var selected_text = ed.selection.getContent();
                var return_text = '';
                return_text = '[xml]' + selected_text + '[/xml]';
                ed.execCommand('mceInsertContent', 0, return_text);
            });

			ed.addCommand('css', function() {
                var selected_text = ed.selection.getContent();
                var return_text = '';
                return_text = '[css]' + selected_text + '[/css]';
                ed.execCommand('mceInsertContent', 0, return_text);
            });

			ed.addCommand('js', function() {
                var selected_text = ed.selection.getContent();
                var return_text = '';
                return_text = '[js]' + selected_text + '[/js]';
                ed.execCommand('mceInsertContent', 0, return_text);
            });

			ed.addCommand('js', function() {
                var selected_text = ed.selection.getContent();
                var return_text = '';
                return_text = '[blank]' + selected_text + '[/blank]';
                ed.execCommand('mceInsertContent', 0, return_text);
            });


			 ed.addCommand('youtube', function() {
                var selected_text = ed.selection.getContent();
                var return_text = '';
                return_text = '[youtube]' + selected_text + '[/youtube]';
                ed.execCommand('mceInsertContent', 0, return_text);
            });

            ed.addButton('xml', {
                title: 'Code XMl/HTML Syntaxique',
                cmd: 'xml',
                image: 'http://www.emmanuelbeziat.com/blog/wp-content/themes/emmanuelb/img/xml.png'
            });

			ed.addButton('css', {
                title: 'Code CSS Syntaxique',
                cmd: 'css',
                image: 'http://www.emmanuelbeziat.com/blog/wp-content/themes/emmanuelb/img/css.png'
            });

			ed.addButton('js', {
                title: 'Code Javascript Syntaxique',
                cmd: 'js',
                image: 'http://www.emmanuelbeziat.com/blog/wp-content/themes/emmanuelb/img/js.png'
            });

			ed.addButton('blank', {
                title: 'Code simple Syntaxique',
                cmd: 'blank',
                image: 'http://www.emmanuelbeziat.com/blog/wp-content/themes/emmanuelb/img/blank.png'
            });

			ed.addButton('youtube', {
                title: 'Vidéo youtube',
                cmd: 'youtube',
                image: 'http://www.emmanuelbeziat.com/blog/wp-content/themes/emmanuelb/img/youtube.png'
            });
        },

        createControl: function(n, cm) {
            return null;
        },

        getInfo: function() {
            return {
                    longname: 'Emmanuel B. Template Buttons',
                    author: 'Emmanuel B.',
                    authorurl: 'http://www.emmanuelbeziat.com',
                    infourl: '-',
                    version: "2.1"
            };
        }
    });

    // Register plugin
    tinymce.PluginManager.add('newbtn', tinymce.plugins.News);
})();