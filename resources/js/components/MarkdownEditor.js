import "codemirror/lib/codemirror.css";
import "@toast-ui/editor/dist/toastui-editor.css";
import Editor from "@toast-ui/editor";

class MarkdownEditor {
    constructor(element) {
        this.editor = new Editor({
            el: element,
            previewStyle: "vertical",
            height: "500px",
            usageStatistics: false
        });
    }

    getMarkdown() {
        return this.editor.getMarkdown();
    }
}

export default MarkdownEditor;
