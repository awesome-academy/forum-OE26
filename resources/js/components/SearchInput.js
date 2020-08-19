import path from "path";

class SearchInput {
    constructor(d) {
        this.input = d.getElementById("search-input");
        this.datalist = d.getElementById("search-datalist");
        this.optionTag = d.createElement("option");

        if (this.input && this.datalist) {
            this.input.addEventListener("input", this.onInput.bind(this));
        }
    }

    async onInput(e) {
        const query = e.target.value;

        const response = await fetch(path.resolve("search", query));
        const data = await response.json();

        this.datalist.innerHTML = "";
        data.forEach(title => {
            const option = this.optionTag.cloneNode(true);
            option.value = title;

            this.datalist.appendChild(option);
        });
    }
}

export default SearchInput;
