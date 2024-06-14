(function () {
  var currentDomain = window.location.protocol + "//" + window.location.host;
  tinymce.create("tinymce.plugins.Wptuts", {
    init: function (editor, url) {
      editor.addButton('orange', {
        title: 'Orange text',
        cmd: 'orange',
        image:
          // TODO remove rech before deploy
          currentDomain +
          '/rech/wp-content/themes/rech/build/images/orange.svg',
      });
      editor.addButton('decor', {
        title: 'Decor text',
        cmd: 'decor',
        image:
          currentDomain +
          '/rech/wp-content/themes/rech/build/images/decor.svg',
      });
      editor.addCommand('orange', function () {
        let selected_text = editor.selection.getContent({
          format: 'html',
        });

        let open_column = '<span class="orange">' + selected_text + '</span>';
        let close_column = '';
        let return_text = '';
        return_text = open_column + close_column;
        editor.execCommand('mceReplaceContent', false, return_text);
      });
      editor.addCommand('decor', function () {
        let selected_text = editor.selection.getContent({
          format: 'html',
        });

        let open_column = '<span class="decor">' + selected_text + '</span>';
        let close_column = '';
        let return_text = '';
        return_text = open_column + close_column;
        editor.execCommand('mceReplaceContent', false, return_text);
      });
    },
  });
  tinymce.PluginManager.add("wptuts", tinymce.plugins.Wptuts);
})();
