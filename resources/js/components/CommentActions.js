import path from "path";

export default function()
{
    const language = document.querySelector('html').lang;

    $("#updateCommentModal").on("show.bs.modal", function(event) {
        const button = $(event.relatedTarget);
        const id = button.data("id").toString();
        const content = button.data("content");
        const modal = $(this);
        const action = path.resolve('comments', id);
        modal.find("#update-comment").attr("action", action);
        modal.find("#comment-content-input").val(content);
    });

    document.querySelectorAll(".delete-comment-form")
        .forEach((deleteForm) => {
            deleteForm.parentElement
                .querySelector(".delete-comment-button")
                .addEventListener("click", (e) => {
                    e.preventDefault();
                    language === 'vi'
                    ? confirm('Bạn có thực sự muốn xoá bình luận này?')
                    : confirm('Do you really want to delete this comment?');
                    deleteForm.submit();
                });
        });
}
