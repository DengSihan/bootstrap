<template>
    <main>
        {{ error }}
    </main>
</template>
<script type="text/javascript">
export default {
    props: {
        error: {
            required: true
        }
    },
    mounted(){
        this.$nextTick(() => {
            document.querySelectorAll('.vs-tooltip').forEach(el => el.remove());
        });
    }
}
</script>
