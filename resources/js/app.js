/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

import "codemirror/lib/codemirror.css";
import "@toast-ui/editor/dist/toastui-editor.css";

import path from "path";

import Sidebar from "./components/SideBar";
import LogoutButton from "./components/LogoutButton";
import MarkdownEditor from "./components/MarkdownEditor";
import CreateQuestionForm from "./components/CreateQuestionForm";
import MarkdownViewer from "./components/MarkdownViewer";
import Post from "./components/Post";
import SortedTypeGroupButton from "./components/SortedTypeGroupButton";
import EditQuestionForm from "./components/EditQuestionForm";
import ShareButtons from "./components/ShareButtons";
import CreateAnswerForm from "./components/CreateAnswerForm";
import SearchInput from "./components/SearchInput";
import commentActions from "./components/CommentActions";
import VoteActions from "./components/VoteActions";
import EditAnswerForm from "./components/EditAnswerForm";
import "pusher-js";
import Notification from "./components/Notification";

const sidebar = new Sidebar(document);
const logoutButton = new LogoutButton(document);

const searchInput = new SearchInput(document);

const editorDiv = document.getElementById("editor");
const editor = editorDiv && new MarkdownEditor(editorDiv);

const createQuestionForm =
    window.location.pathname === path.resolve("questions", "create") &&
    new CreateQuestionForm(document, editor);

const post = new Post(MarkdownViewer);
const sortedTypeGroupButton = new SortedTypeGroupButton(document);

const editQuestionForm =
    /^\/questions\/\d+\/edit$/gi.test(window.location.pathname) &&
    new EditQuestionForm(document, editor);

const shareButtons = new ShareButtons(document);

const createAnswerForm =
    /^\/questions\/\d+$/gi.test(window.location.pathname) &&
    new CreateAnswerForm(document, editor);

/^\/questions\/\d+$/gi.test(window.location.pathname) && commentActions();

const voteActions =
    /^\/questions\/\d+$/gi.test(window.location.pathname) &&
    new VoteActions(document);

const editAnswerForm =
    /^\/answers\/\d+\/edit$/gi.test(window.location.pathname) &&
    new EditAnswerForm(document, editor);

const notification = new Notification();
