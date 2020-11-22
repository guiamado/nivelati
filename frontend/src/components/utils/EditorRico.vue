<template>
  <quill-editor
    class="editor black--text"
    ref="myTextEditor"
    :value="content"
    :options="editorOption"
    @change="onEditorChange"
  />
</template>

<script>
import hljs from "highlight.js";

export default {
  name: "EditorRico",
  props: {
    placeHolder: {
      type: String,
      required: false,
    },
    contentProp: {
      type: String,
      required: false,
    },
  },
  data() {
    return {
      editorOption: {
        modules: {
          toolbar: [
            ["bold", "italic", "underline", "strike"],
            ["blockquote", "code-block"],
            [{ header: 1 }, { header: 2 }],
            [{ list: "ordered" }, { list: "bullet" }],
            [{ script: "sub" }, { script: "super" }],
            [{ indent: "-1" }, { indent: "+1" }],
            [{ direction: "rtl" }],
            [{ size: ["small", false, "large", "huge"] }],
            [{ header: [1, 2, 3, 4, 5, 6, false] }],
            [{ font: [] }],
            [{ color: [] }, { background: [] }],
            [{ align: [] }],
            ["clean"],
            // ["link", "image", "video"],
          ],
          syntax: {
            highlight: (text) => hljs.highlightAuto(text).value,
          },
        },
        placeholder: this.placeHolder
          ? this.placeHolder
          : "Digite aqui a descrição da sua publicação.",
      },
      content: this.contentProp ? this.contentProp : null,
    };
  },
  // mounted() {
  //   console.log("this is Quill instance:", this.editor);
  // },
  computed: {
    editor() {
      return this.$refs.myTextEditor.quill;
    },
  },
  methods: {
    onEditorChange(value) {
      this.content = value.html;
      this.$emit("onEditorChange", value.html);
    },
  },
};
</script>

<style>
</style>