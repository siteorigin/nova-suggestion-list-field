<template>
    <span>{{ field.value.join(', ') }}</span>
</template>

<script>
export default {
    props: ['resourceName', 'field'],
}
</script>
