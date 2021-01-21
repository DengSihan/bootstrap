<template>
	<fragment>
		<vs-button
			type="button"
			size="large"
			square
			transparent
			@click="show = !show">
			<span class="capitalize">
				{{ $t('theme') }}
			</span>
		</vs-button>
		<section>
			<vs-dialog
				square
				blur
				v-model="show">
				<form class="p-4">
					<section class="my-4"
						v-for="theme in ['system', 'light', 'dark']"
						:key="theme">
						<label>
				            <input class="checkbox"
				                type="checkbox"
				                :checked="theme === currentTheme"
				                @change="$store.commit('theme/setTheme', theme)">
				            <span class="capitalize text-base">
				                {{ $t(theme) }}
				            </span>
				        </label>		
					</section>
				</form>
			</vs-dialog>
		</section>
	</fragment>
</template>
<script type="text/javascript">
import { mapGetters } from 'vuex';
export default{
	computed: mapGetters({
		currentTheme: 'theme/theme'
	}),
	data(){
		return {
			show: false
		}
	}
}
</script>