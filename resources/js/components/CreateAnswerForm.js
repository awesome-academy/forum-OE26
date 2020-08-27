class CreateAnswerForm {
    constructor(d, bodyEditor) {
        this.form = d.getElementById("new-answer-form");
        this.submitButton = d.getElementById("new-answer-submit");
        this.bodyEditor = bodyEditor;

        if (this.submitButton) {
            this.submitButton.addEventListener("click", this.submit.bind(this));
        }
    }

    submit(e) {
        if (this.form && this.submitButton && this.bodyEditor) {
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

export default CreateAnswerForm;
