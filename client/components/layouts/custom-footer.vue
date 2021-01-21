<template>
    <footer>
        Footer
        <theme-selector/>
        <locale-selector/>
    </footer>
</template>
<script type="text/javascript">
import ThemeSelector from '@/components/selectors/theme';
import LocaleSelector from '@/components/selectors/locale';
export default{
	components: {
		ThemeSelector,
		LocaleSelector
	}
}
</script>
