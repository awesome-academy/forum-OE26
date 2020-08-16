import path from "path";

class CreateQuestionForm
{
    constructor(d, bodyEditor)
    {
        this.form = d.getElementById("edit-question-form");
        this.summitButton = d.getElementById("edit-question-submit");
        this.bodyEditor = bodyEditor;
        this.contentId = this.form.getAttribute("content-id").trim();

        this.getContent();

        this.summitButton.addEventListener("click", this.submit.bind(this));
    }

    submit(e)
    {
        if (this.form && this.summitButton && this.bodyEditor) {
            e.preventDefault();

            const input = document.createElement("input");
            input.setAttribute("name", "content");
            input.setAttribute("value", this.bodyEditor.getMarkdown());
            input.setAttribute("type", "hidden");

            this.form.appendChild(input);
            this.form.submit();
        }
    }

    async getContent()
    {
        const response = await fetch(path.resolve("contents", this.contentId));
        const data = await response.json();

        this.bodyEditor.setMarkdown(data["content"]);
    }
}

export default CreateQuestionForm;
