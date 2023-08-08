<template>
    <div @click="sendNumber" class="bg-[#fcb0b2] dark:bg-[#fa30aa] font-sans font-bold w-full rounded-md py-[10px] cursor-pointer text-white"><i :class="operator"></i></div>
</template>

<script>

export default {
    name: 'OperatorButton',
    props : ['operator'],
    methods : {
        sendNumber(){ 
            if(this.operator == 'fa-solid fa-divide'){
                this.$emit('select', '/');
            }else if(this.operator == 'fa-solid fa-minus'){
                this.$emit('select', '-');
            }else if(this.operator == 'fa-solid fa-xmark'){
                this.$emit('select', '*');
            }else{
                this.$emit('select', '+');
            }
        }
    }
}
</script>