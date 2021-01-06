<template>
    <section class="flex items-center justify-between">
        <label>
            <input class="checkbox"
                type="checkbox"
                :checked="value"
                @change="$emit('input', $event.target.checked)">
            <span class="capitalize text-base">
                {{ $t('remember_me') }}
            </span>
        </label>
    </section>
</template>
<script type="text/javascript">
export default{
    props: {
        value: {
            default: false
        }
    }
}
</script>
