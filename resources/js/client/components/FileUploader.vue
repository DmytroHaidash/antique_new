<template>
    <div>
        <input type="file" id="file" ref="myFiles" name="files[]"
               accept=".jpg, .jpeg, .png, .zip, .rar, .pdf, .doc, .docx, .odt, .pages"
               @change="handle" multiple
               :required="required">
        <span class="block text-sm text-muted">(jpg, jpeg, png, zip, rar, pdf, doc, docx, odt, pages) max-5Mb</span>
        <div v-if="files.length" class="mt-4">
            <div  v-for="(file, index) in files" :key="index" class="flex justify-between mb-3 pb-2 border-b border-gray-200 border-solid">
            <span>{{file.name}}</span>
                <a href="#" class="text-red-600 ml-4" @click.prevent="remove(index)">
                    X
                </a>
            </div>
        </div>
    </div>
</template>
<script>
  export default {
    props: ['required'],
    data() {
      return {
        files: [],
      }
    },
    methods: {
      handle({target}) {
        const fileList = Array.from(target.files);
        const dt = new DataTransfer();

        if (!fileList.length) return;

        this.files = [...this.files, ...fileList];
        this.files.forEach(file => dt.items.add(file));
        this.$refs.myFiles.files = dt.files;
      },
      remove(index) {
        this.files.splice(index, 1);
        this.$refs.myFiles.files.splice(index, 1);
      }
    }
  }
</script>