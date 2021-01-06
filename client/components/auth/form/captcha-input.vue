<template>
    <section class="flex justify-between items-start">
        <vs-input
            :state="errors.length?'danger':''"
            square
            class="w-1/2 no-arrows-input theme"
            :value="value"
            @input="$emit('input', $event)"
            autocomplete="off"
            name="verification"
            required
            type="text"
            :label-placeholder="$t('verification').toCapitalizePhrases()">
            <template #icon>
                <i class='mdi mdi-gesture text-xl'></i>
            </template>
            <template #message-danger v-if="errors.length">
                <ul class="pl-4 my-4">
                    <li v-for="error in errors">
                        {{ error }}
                    </li>
                </ul>
            </template>
        </vs-input>
        <vs-tooltip square>
            <img :src="captcha.image_content" class="cursor-pointer h-10" @click="$emit('refresh')">
            <template #tooltip>
                {{ $t('refresh_captcha').toCapitalizePhrases() }}
            </template>
        </vs-tooltip>
    </section>
</template>
<script type="text/javascript">
export default{
    props: {
        captcha: {
            required: true
        },
        value: {
            type: String
        },
        errors: {
            type: Array
        }
    }
}
</script>
