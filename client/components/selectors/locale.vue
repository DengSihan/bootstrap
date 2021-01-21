<template>
	<ul>
		<li v-for="locale in locales"
			v-if="locale !== currentLocale"
			:key="locale">
			<nuxt-link :to="getLocaleRoute(locale)" class="capitalize" :lang="locale">
				{{ $i18n.getLocaleMessage(locale).locale }}
			</nuxt-link>
		</li>
	</ul>
</template>
<script type="text/javascript">
import config from '@/config';
import { mapGetters } from 'vuex';
export default{
	computed: mapGetters({
		currentLocale: 'locale/locale'
	}),
	data(){
		return {
			locales: config.locale.available
		}
	},
	methods: {
		getLocaleRoute(locale){
			let route = this.$route;
			route.params.locale = locale;
			return route;
		}
	}
}
</script>