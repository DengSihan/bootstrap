<template>
    <vs-input
        :state="errors.length?'danger':''"
        square
        class="w-full my-6 theme"
        :value="value"
        @input="$emit('input', $event)"
        :autocomplete="false"
        type="text"
        name="email-verification"
        required
        :label-placeholder="$t('email_verification').toCapitalizePhrases()">
        <template #icon>
            <i class='mdi mdi-key text-xl'></i>
        </template>
        <template #message-danger v-if="errors.length">
            <ul class="pl-4 my-4">
                <li v-for="error in errors">
                    {{ error }}
                </li>
            </ul>
        </template>
    </vs-input>
</template>
<script type="text/javascript">
export default{
    props: {
        value: {
            type: String
        },
        errors: {
            type: Array
        },
        required: {
            default: true,
            required: false
        },
        name: {
            default: 'password',
            required: false
        },
        autocomplete: {
            default: 'password',
            required: false
        }
    }
}
</script>
