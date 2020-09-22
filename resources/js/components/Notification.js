import Echo from "laravel-echo";
import path from "path";

const pusherKey = "eaadce48f0174da90ecf";

class Notification {
    constructor() {
        this.echo = new Echo({
            broadcaster: "pusher",
            key: pusherKey,
            cluster: "ap1",
            forceTLS: true
        });
        this.numOfNotifications = 0;
        this.notificationTitle = document.getElementById("navbarDropdown1");
        this.notificationList = document.getElementById("navbarDropdownList1");
        this.rootTitle = document.querySelector("title");

        const element = document.getElementById("auth-id");
        this.userId = element ? element.value : 0;

        this.getNotifications();
        this.getMessages();
    }

    updateTitle() {
        let numInTitle = "";

        this.notificationTitle.innerText = this.notificationTitle.innerText
            .trim()
            .replace(/\ \[\d+\]$/, "");
        this.rootTitle.innerText = this.rootTitle.innerText
            .trim()
            .replace(/\[\d+\]$/, "");

        if (this.numOfNotifications > 0) {
            numInTitle = `[${this.numOfNotifications}]`;
        }

        this.notificationTitle.innerText += " " + numInTitle;
        this.rootTitle.innerText += numInTitle;
    }

    getMessages() {
        if (this.userId) {
            this.echo
                .private("App.Models.User." + this.userId)
                .notification(notification => {
                    this.numOfNotifications++;
                    this.updateTitle();

                    const notificationList = document.getElementById(
                        "navbarDropdownList1"
                    );
                    const notificationTag = notificationList.children[0].cloneNode(
                        true
                    );

                    notificationTag.innerText =
                        document.documentElement.lang === "en"
                            ? notification.message_en
                            : notification.message_vi;
                    notificationTag.href = path.resolve(
                        "questions",
                        notification.question_id.toString()
                    );
                    notificationTag.classList.add("color-3");

                    notificationList.insertBefore(
                        notificationTag,
                        notificationList.children[0]
                    );
                });
        }
    }

    async getNotifications() {
        const response = await fetch(path.resolve("question-notifications"));
        const data = await response.json();

        if (data.length) {
            const notificationList = document.getElementById(
                "navbarDropdownList1"
            );

            const notificationTag = notificationList.children[0].cloneNode(
                true
            );
            this.notificationList.innerHTML = "";

            let notificationsCount = 0;

            data.forEach(value => {
                const node = notificationTag.cloneNode(true);
                node.href = path.resolve(
                    "questions",
                    value.data.question_id.toString()
                );
                node.innerText = value.message;

                if (value.read_at === null) {
                    notificationsCount++;

                    node.classList.add("color-3");
                }

                this.notificationList.appendChild(node);
            });

            this.numOfNotifications = notificationsCount;
            this.updateTitle();
        }
    }
}

export default Notification;
