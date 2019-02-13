<template>
  <div class="block__body">
    a17-redactor
    <a17-redactor :name="fieldName('html')" inStore="value"></a17-redactor>
  </div>
</template>

<script>
  import BlockMixin from '@/mixins/block'

  export default {
    name: 'A17BodytextRedactor',
    mixins: [BlockMixin]
  }
</script>
