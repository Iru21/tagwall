<template>
    <header v-if="$slots.header" class="bg-white/5 border-border py-3 border-b mb-8">
        <div>
            <slot name="header"/>
        </div>
    </header>
    <main class="grow flex flex-col">
        <div :class="{
            'my-auto': !$slots.header
        }">
            <slot/>
        </div>
    </main>
</template>
