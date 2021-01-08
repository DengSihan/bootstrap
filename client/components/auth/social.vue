<template>
    <div class="flex justify-center -mx-3">
        <vs-tooltip
            class="mx-3"
            square
            v-for="social in socials"
            :key="social.key">
            <a :href="`${api}/auth/socials/${social.key}/authorizations`">
                <i class="mdi text-3xl"
                    :style="{
                        color: social.color
                    }"
                    :class="`mdi-${social.icon}`"></i>
            </a>
            <template #tooltip>
                <span class="capitalize">
                    {{ $t('login_with', {social: social.key}) }}
                </span>
            </template>
        </vs-tooltip>
    </div>
</template>
<script type="text/javascript">
import config from '@/config';
export default{
    data(){
        return {
            api: config.api.url,
            socials: config.social
        }
    }
}
</script>
