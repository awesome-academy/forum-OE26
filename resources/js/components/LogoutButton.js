class LogoutButton {
    constructor(d) {
        this.button = d.getElementById("logout-btn") || null;
        this.form = d.getElementById("logout-form") || null;

        if (this.button && this.form) {
            this.button.addEventListener("click", this.onLogout.bind(this));
        }
    }

    onLogout(e) {
        e.preventDefault();

        if (this.button && this.form) {
            this.form.submit();
        }
    }

    logout() {
        if (this.button && this.form) {
            this.form.submit();
        }
    }
}

export default LogoutButton;
