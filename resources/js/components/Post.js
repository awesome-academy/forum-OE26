class Post {
    constructor(ViewerClass) {
        this.contentDivs = document.querySelectorAll(".viewer");

        this.contentDivs.length &&
            this.contentDivs.forEach(contentDiv => {
                const viewer = new ViewerClass(contentDiv);
            });
    }
}

export default Post;
