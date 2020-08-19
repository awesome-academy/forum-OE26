import path from "path";

class ShareButtons
{
    constructor(d)
    {
        this.buttons = d.querySelectorAll(".share-btn");

        this.buttons.forEach(button => {
            button.addEventListener("click", this.onClick.bind(this));
        });
    }

    onClick(e)
    {
        e.preventDefault();

        const url = document.createElement("input"),
            text = window.location.href;

        document.body.appendChild(url);
        url.value = text;
        url.select();
        document.execCommand("copy");
        document.body.removeChild(url);
        alert("The url is saved to clipboard.");
    }
}

export default ShareButtons;
