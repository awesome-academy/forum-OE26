import "@toast-ui/editor/dist/toastui-editor-viewer.css";

import path from "path";

import Viewer from "@toast-ui/editor/dist/toastui-editor-viewer";

class MarkdownViewer {
    constructor(element) {
        this.viewer = new Viewer({
            el: element
        });

        this.contentId = element.getAttribute("content-id").trim();

        this.render();
    }

    async render() {
        const response = await fetch(path.resolve("contents", this.contentId));
        const data = await response.json();

        this.viewer.setMarkdown(data["content"]);
    }
}

export default MarkdownViewer;
