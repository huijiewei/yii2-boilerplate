<template>
  <i :class="['anticon','anticon-' +type]"></i>
</template>

<script>
  export default {
    name: 'BpIcon',
    props: ['type']
  }
</script>
