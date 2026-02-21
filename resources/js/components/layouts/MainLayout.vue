<template>
    <header v-if="$slots.header">
        <slot name="header"/>
    </header>
    <main>
        <div :class="{
            'my-auto': !$slots.footer && !$slots.header
        }">
            <slot/>
        </div>
    </main>
    <footer v-if="$slots.footer">
        <slot name="footer"/>
    </footer>
</template>
<script setup lang="ts">

</script>
