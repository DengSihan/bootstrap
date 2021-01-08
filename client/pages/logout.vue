<template>
    <main class="mx-auto w-full sm:w-full md:w-2/3 lg:w-1/3 xl:w-1/4">
        <section class="p-2 sm:p-2 md:p-0">
            <h1 class="my-6 text-3xl">
                {{ $t('logout').toCapitalizePhrases() }}
            </h1>
            <form @submit.prevent="logout">
                <p class="my-6 capitalize">
                    {{ $t('are_you_sure_to_logout') }}
                </p>
                <div class="my-6 flex justify-between">
                    <vs-button type="submit" data-action="0" square class="m-0">
                         {{ $t('cancel').toUpperCase() }}
                    </vs-button>
                    <vs-button danger type="submit" data-action="1" square class="m-0">
                         {{ $t('sure').toUpperCase() }}
                    </vs-button>
                </div>
            </form>
        </section>
    </main>
</template>
<script type="text/javascript">
export default{
    methods: {
        logout(e){
            if (e.submitter.getAttribute('data-action') > 0) {
                let loading = this.$vs.loading();
                this.$nuxt.$loading.start();
                this.$store.dispatch('auth/logout').then(() => {
                    loading.close();
                    this.$nuxt.$loading.finish();
                    this.$router.push(this.generateRoute({
                        name: 'login',
                    }));
                });
            }
            else{
                this.$router.go(-1);
            }
        }
    }
}
</script>
