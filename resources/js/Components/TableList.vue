<template>
    <div class="overflow-x-auto border-x border-t">
        <table class="table-auto w-full">
            <thead class="border-b">
                <slot name="header" />
            </thead>
            <tbody>
                <slot name="body" />
            </tbody>
        </table>
    </div>
</template>
