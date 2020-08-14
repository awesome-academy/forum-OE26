class SortedTypeGroupButton {
    constructor(d) {
        this.form = d.getElementById("sorted-options-form");
        this.options = this.form && this.form.querySelectorAll("input");

        this.options &&
            this.options.forEach(option => {
                option.addEventListener("click", this.onSubmit.bind(this));
            });
    }

    onSubmit() {
        if (this.options.length > 0) {
            this.form.submit();
        }
    }
}

export default SortedTypeGroupButton;
