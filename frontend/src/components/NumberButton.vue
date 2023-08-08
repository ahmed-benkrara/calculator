<template>
    <div @click="sendNumber" class="bg-[#f1f1f1] dark:bg-[#2e2b48] font-sans font-bold w-full rounded-md py-[10px] cursor-pointer">{{ number }}</div>
</template>

<script>

export default {
    name: 'ButtonNumber',
    props : ['number'],
    methods : {
        sendNumber(){
            this.$emit('select', this.number);
        }
    }
}
</script>