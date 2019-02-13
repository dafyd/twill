<template>
  <textarea ref="redactor" :name="name" :placeholder="placeholder" :value="value" />
</template>

<script>
  import { loadScript } from '@/utils/loader'

  import assignIn from 'lodash/assignin'

  export default {
    name: 'Redactor',
    redactor: false,
    watch: {
      value (newValue, oldValue) {
        if (!this.redactor.editor.isFocus()) {
          this.redactor.source.setCode(newValue)
        }
      }
    },
    props: {
      value: {
        default: '',
        type: String
      },
      placeholder: {
        type: String,
        default: null
      },
      name: {
        type: String,
        default: null
      },
      config: {
        type: Object,
        default: () => {
          return {}
        }
      }
    },
    mounted () {
      this.init()
    },
    methods: {
      init () {
        /* global $R */
        // call Redactor
        loadScript('redactor', '/assets/admin/js/redactor.js', 'text/javascript').then(() => {
          var config = {
            callbacks: {
              changed: (html) => {
                this.handleInput(html)
                return html
              }
            }
          }

          var redactor = $R(this.$refs.redactor, assignIn(config, this.config))
          this.redactor = redactor
          this.$parent.redactor = redactor
        })
      },
      handleInput (val) {
        this.$emit('input', val)
        this.$emit('change', val)
      }
    }
  }
</script>

<style lang="scss">
  @import "../../libs/redactor/_scss/redactor";
  @import "../../libs/redactor/_plugins/inlinestyle/inlinestyle.css";
</style>
