import "codemirror/lib/codemirror.css";
import "@toast-ui/editor/dist/toastui-editor.css";
import Editor from "@toast-ui/editor";

class MarkdownEditor
{
    constructor(element)
    {
        this.editor = new Editor({
            el: element,
            previewStyle: "vertical",
            height: "500px",
            initialEditType: "wysiwyg",
            usageStatistics: false
        });
    }

    getMarkdown()
    {
        return this.editor.getMarkdown();
    }

    setMarkdown(content)
    {
        this.editor.setMarkdown(content);
    }
}

export default MarkdownEditor;
