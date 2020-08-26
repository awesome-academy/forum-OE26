import path from "path";

class VoteActions
{
    constructor(d)
    {
        this.language = d.querySelector("html").lang;
        this.csrfToken = d.querySelector('meta[name=csrf-token]').content;
        this.upVoteButtons = d.querySelectorAll(".up-vote");
        this.downVoteButtons = d.querySelectorAll(".down-vote");

        this.upVoteButtons.forEach(upVoteButton => {
            upVoteButton.addEventListener("click", this.upVote.bind(this));
        });

        this.downVoteButtons.forEach(downVoteButton => {
            downVoteButton.addEventListener("click", this.downVote.bind(this));
        });
    }

    async upVote(e)
    {
        e.preventDefault();
        const button = e.target;
        const id = button.dataset.question || button.dataset.answer;
        const type = button.dataset.question ? "1" : button.dataset.answer ? "2" : "0";

        const response = await fetch(path.resolve("vote", "up"), {
            method: 'PUT',
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": this.csrfToken,
            },
            body: JSON.stringify({
                id: parseInt(id),
                type: parseInt(type),
            }),
        });
        const data = await response.json();

        if (!("vote" in data)) {
            this.language === 'vi'
            ? alert("Bạn cần đăng nhập để có thể vote :)")
            : alert("You need to log in to be able to vote :(");
        }

        this.render(button.parentElement, data);
    }

    async downVote(e)
    {
        e.preventDefault();
        const button = e.target;
        const id = button.dataset.question || button.dataset.answer;
        const type = button.dataset.question ? "1" : button.dataset.answer ? "2" : "0";

        const response = await fetch(path.resolve("vote", "down"), {
            method: 'PUT',
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": this.csrfToken,
            },
            body: JSON.stringify({
                id: parseInt(id),
                type: parseInt(type),
            })
        });
        const data = await response.json();

        if (!("vote" in data)) {
            this.language === 'vi'
            ? alert("Bạn cần đăng nhập để có thể vote :)")
            : alert("You need to log in to be able to vote :(");
        }

        this.render(button.parentElement, data);
    }

    render(element, data)
    {
        switch (data.vote) {
            case 1:
                element.querySelector(".up-vote").classList.add("color-3");
                element.querySelector(".down-vote").classList.remove("color-3");
                element.querySelector("h5").innerText = data.votes_sum;
                break;
            case -1:
                element.querySelector(".up-vote").classList.remove("color-3");
                element.querySelector(".down-vote").classList.add("color-3");
                element.querySelector("h5").innerText = data.votes_sum;
                break;
            default:
                element.querySelector(".up-vote").classList.remove("color-3");
                element.querySelector(".down-vote").classList.remove("color-3");
                element.querySelector("h5").innerText = data.votes_sum;
        }
    }
}

export default VoteActions;
