class CreateQuestionForm {
    constructor(d, bodyEditor) {
        this.form = d.getElementById("new-question-form");
        this.summitButton = d.getElementById("new-question-submit");
        this.bodyEditor = bodyEditor;

        this.summitButton.addEventListener("click", this.submit.bind(this));
    }

    submit(e) {
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
}

export default CreateQuestionForm;
