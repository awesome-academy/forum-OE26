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

const sidebar = new Sidebar(document);
const logoutButton = new LogoutButton(document);

const editorDiv = document.getElementById("editor");
const editor = editorDiv && new MarkdownEditor(editorDiv);

const createQuestionForm =
    window.location.pathname === path.resolve("questions", "create") &&
    new CreateQuestionForm(document, editor);

const post = new Post(MarkdownViewer);
const sortedTypeGroupButton = new SortedTypeGroupButton(document);
