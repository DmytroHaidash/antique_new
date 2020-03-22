<template>
    <div class="form-group">
        <label v-text="label" v-if="label"></label>

        <div class="border rounded">
            <menubar :editor="editor" @show-image-modal="showImageModal"/>
            <editor-content class="p-3" :editor="editor"/>
            <image-modal ref="imageModal" @insert="addCommand"/>
        </div>

        <input type="hidden" :name="name" :value="html">
    </div>
</template>

<script>
  import ImageModal from './ImageModal';
  import Menubar from './Menubar';
  import {Editor, EditorContent} from 'tiptap';
  import {
    Blockquote,
    Bold,
    BulletList,
    HardBreak,
    Heading,
    History,
    HorizontalRule,
    Image,
    Italic,
    Link,
    ListItem,
    OrderedList,
    Strike,
    TodoItem,
    TodoList,
    Underline
  } from 'tiptap-extensions';

  export default {
    props: {
      label: String,
      content: String,
      name: {
        type: String,
        default() {
          return 'description';
        }
      }
    },

    components: {
      ImageModal,
      EditorContent,
      Menubar,
    },

    methods: {
      showImageModal(command) {
        this.$refs.imageModal.showModal({command})
      },

      addCommand(data) {
        if (data.command !== null) {
          data.command(data.data);
        }
      },
    },

    data() {
      return {
        editor: null,
        html: this.content
      }
    },

    mounted() {
      this.editor = new Editor({
        extensions: [
          new Blockquote(),
          new BulletList(),
          new HardBreak(),
          new Heading({levels: [2, 3, 4]}),
          new HorizontalRule(),
          new ListItem(),
          new OrderedList(),
          new TodoItem(),
          new TodoList(),
          new Link(),
          new Bold(),
          new Italic(),
          new Strike(),
          new Underline(),
          new History(),
          new Image()
        ],
        content: this.content,
        onUpdate: ({getHTML}) => {
          this.html = getHTML()
        },
      })
    },

    beforeDestroy() {
      this.editor.destroy()
    },
  }
</script>

<style lang="scss" src="./assets/sass/main.scss"></style>
