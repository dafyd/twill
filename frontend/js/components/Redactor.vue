<template>
  <a17-inputframe :error="error" :note="note" :label="label" :locale="locale" @localize="updateLocale" :size="size" :name="name" :required="required">
    <div class="wysiwyg__outer" :class="textfieldClasses">
      <input :name="name" type="hidden" v-model="value" />
      <template>
        <div class="wysiwyg" :class="textfieldClasses">
          <redactor v-model="value" placeholder="Type here..." :config="configOptions" :image-upload="imageUpload" :image-list="image-list" />
        </div>
      </template>
    </div>
  </a17-inputframe>
</template>

<script>
  import { mapState } from 'vuex'

  import debounce from 'lodash/debounce'

  import InputMixin from '@/mixins/input'
  import FormStoreMixin from '@/mixins/formStore'
  import InputframeMixin from '@/mixins/inputFrame'
  import LocaleMixin from '@/mixins/locale'

  import Redactor from '@/components/Redactor/Redactor'

  export default {
    name: 'A17Redactor',
    mixins: [InputMixin, InputframeMixin, LocaleMixin, FormStoreMixin],
    components: {Redactor},
    props: {
      type: {
        type: String,
        default: 'text'
      },
      imageUpload: {
        type: String,
        default: null
      },
      imageList: {
        type: String,
        default: null
      },
      prefix: {
        type: String,
        default: ''
      },
      maxlength: {
        type: Number,
        default: 0
      },
      initialValue: {
        default: ''
      },
      options: {
        type: Object,
        required: false,
        default: function () {
          return {}
        }
      }
    },
    computed: {
      textareaHeight: function () {
        return {
          height: this.editorHeight
        }
      },
      textfieldClasses: function () {
        return {
          's--disabled': this.disabled,
          's--focus': this.focused
        }
      },
      ...mapState({
        baseUrl: state => state.form.baseUrl
      })
    },
    data: function () {
      return {
        value: this.initialValue,
        editorHeight: 50,
        toolbarHeight: 52,
        focused: false,
        activeSource: false
      }
    },
    watch: {
      value (newValue, oldValue) {
        this.textUpdate()
      }
    },
    methods: {
      updateFromStore: function (newValue) { // called from the formStore mixin
        if (typeof newValue === 'undefined') newValue = ''

        if (this.value !== newValue) {
          console.warn('updateFromStore - Update UI value : ' + this.name + ' -> ' + newValue)
          this.value = newValue
        }
      },
      textUpdate: debounce(function () {
        this.saveIntoStore() // see formStore mixin
      }, 600)
    },
    mounted: function () {
      this.configOptions = {}
    },
    beforeDestroy () {
    }
  }
</script>

<style lang="scss" scoped>
  .wysiwyg__button {
    margin-top:20px;
  }
</style>
<style lang="scss">
</style>
