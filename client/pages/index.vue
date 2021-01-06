<template>
    <main>
        <h1 class="capitalize">
            index
        </h1>
        <ol>
            <li>
                <nuxt-link :to="generateRoute({name: 'login'})">login</nuxt-link>
            </li>
            <li>
                <nuxt-link :to="generateRoute({name: 'register'})">register</nuxt-link>
            </li>
        </ol>
    </main>
</template>
