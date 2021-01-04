<template>
    <main>
        <h1 class="capitalize">
            index
        </h1>
        <ol>
            <li>
                <nuxt-link :to="{name: 'login'}">login</nuxt-link>
            </li>
            <li>
                <nuxt-link :to="{name: 'register'}">register</nuxt-link>
            </li>
        </ol>
    </main>
</template>
