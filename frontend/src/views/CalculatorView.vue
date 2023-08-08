<template>
    <!--Container-->
    <div class="center-container w-full h-fit min-h-screen bg-[#fcb0b2] dark:bg-[#fa30aa]">
        <div class="calcul p-2 dark:bg-[#151434] dark:text-white">
            <div class="w-full h-[42px]">

                <svg id="light" @click="switchMode('light')" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-[25px] h-[25px] ml-2 mt-2 cursor-pointer"><path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" class="stroke-slate-400 dark:stroke-white"></path><path d="M12 4v1M17.66 6.344l-.828.828M20.005 12.004h-1M17.66 17.664l-.828-.828M12 20.01V19M6.34 17.664l.835-.836M3.995 12.004h1.01M6 6l.835.836" class="stroke-slate-400 dark:stroke-white"></path></svg>
                <svg id="dark" @click="switchMode('dark')" viewBox="0 0 24 24" fill="none" class="w-[25px] h-[25px] ml-2 mt-2 cursor-pointer hidden"><path fill-rule="evenodd" clip-rule="evenodd" d="M17.715 15.15A6.5 6.5 0 0 1 9 6.035C6.106 6.922 4 9.645 4 12.867c0 3.94 3.153 7.136 7.042 7.136 3.101 0 5.734-2.032 6.673-4.853Z" class="fill-transparent"></path><path d="m17.715 15.15.95.316a1 1 0 0 0-1.445-1.185l.495.869ZM9 6.035l.846.534a1 1 0 0 0-1.14-1.49L9 6.035Zm8.221 8.246a5.47 5.47 0 0 1-2.72.718v2a7.47 7.47 0 0 0 3.71-.98l-.99-1.738Zm-2.72.718A5.5 5.5 0 0 1 9 9.5H7a7.5 7.5 0 0 0 7.5 7.5v-2ZM9 9.5c0-1.079.31-2.082.845-2.93L8.153 5.5A7.47 7.47 0 0 0 7 9.5h2Zm-4 3.368C5 10.089 6.815 7.75 9.292 6.99L8.706 5.08C5.397 6.094 3 9.201 3 12.867h2Zm6.042 6.136C7.718 19.003 5 16.268 5 12.867H3c0 4.48 3.588 8.136 8.042 8.136v-2Zm5.725-4.17c-.81 2.433-3.074 4.17-5.725 4.17v2c3.552 0 6.553-2.327 7.622-5.537l-1.897-.632Z" class="fill-slate-400 dark:fill-white"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M17 3a1 1 0 0 1 1 1 2 2 0 0 0 2 2 1 1 0 1 1 0 2 2 2 0 0 0-2 2 1 1 0 1 1-2 0 2 2 0 0 0-2-2 1 1 0 1 1 0-2 2 2 0 0 0 2-2 1 1 0 0 1 1-1Z" class="fill-slate-400 dark:fill-white"></path></svg>
            </div>
            <div class="w-full h-[150px] center-container">
                <h1 class="w-fit max-w-full overflow-hidden h-fit ml-auto font-bold text-[30px] px-2">{{ number }}</h1>
            </div>
            <div class="w-full">
                <div @click="clear()" class="mb-[30px] text-black dark:text-[white] w-fit h-fit ml-auto font-[700] font-kodchasan mr-2 text-[15px] cursor-pointer">DEL</div>
                
                <div class="w-full grid grid-cols-4 gap-[10px] mx-auto px-2">
                    <NumberButton @select="setValue" :number="7" />
                    <NumberButton @select="setValue" :number="8" />
                    <NumberButton @select="setValue" :number="9" />
                    <OperatorButton @select="getOperator" :operator="'fa-solid fa-divide'" />
                    
                    <NumberButton @select="setValue" :number="4" />
                    <NumberButton @select="setValue" :number="5" />
                    <NumberButton @select="setValue" :number="6" />
                    <OperatorButton @select="getOperator" :operator="'fa-solid fa-minus'" />

                    <NumberButton @select="setValue" :number="1" />
                    <NumberButton @select="setValue" :number="2" />
                    <NumberButton @select="setValue" :number="3" />
                    <OperatorButton @select="getOperator" :operator="'fa-solid fa-xmark'" />

                    <NumberButton @select="setValue" :number="'.'" />
                    <NumberButton @select="setValue" :number="0" />
                    <div @click="calculateResult()" class="bg-[#f1f1f1] dark:bg-[#2e2b48] font-sans font-bold w-full rounded-md py-[10px] cursor-pointer">=</div>
                    <OperatorButton @select="getOperator" :operator="'fa-solid fa-plus'" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NumberButton from '@/components/NumberButton.vue';
import OperatorButton from '@/components/OperatorButton.vue';
import axios from 'axios';

export default {
    name: 'CalculatorView',
    data() {
        return {
            number: '0',
            calculation: '',
            hasPoint: false,
        };
    },
    methods: {
        setValue(e) {
            if(this.number === 'infinity'){
                this.clear()
            }

            if (e === '.' && this.hasPoint) {
                return
            }
            
            if (e === '.') {
                this.hasPoint = true
            }

            this.number = this.number === '0' ? e : this.number.toString() + e
        },
        clear() {
            this.number = '0'
            this.calculation = ''
            this.hasPoint = false
        },
        getOperator(e) {
            if(this.number === 'infinity'){
                this.clear()
            }

            if (e === 'fa-solid fa-xmark') {
                this.calculateResult();
            } else {
                this.calculation += this.number + e
                this.number = '0'
                this.hasPoint = false
            }
        },
        async calculateResult() {
            let data = await axios.post('http://127.0.0.1:8000/api/calculate', { expression : (this.calculation + this.number) }, {
                headers : {
                    'Accept': 'application/vnd.api+json',
                    'Content-Type': 'application/vnd.api+json',
                }
            })

            this.number = data.data.result
            this.calculation = ''
            this.hasPoint = false
        },
        switchMode(e){
            let body = document.querySelector('body')
            let light = document.getElementById('light')
            let dark = document.getElementById('dark')
            if(e == 'light'){
                //switch to dark
                body.classList.add('dark')
                light.classList.add('hidden')
                dark.classList.remove('hidden')
            }else{
                //switch to light
                body.classList.remove('dark')
                dark.classList.add('hidden')
                light.classList.remove('hidden')
            }
        }
    },
    components: {
        NumberButton,
        OperatorButton,
    },
};
</script>

<style>
    .center-container{
        @apply flex justify-center items-center;
    }

    .rtl-input{
        direction: rtl;
        text-align: right;
    }

    .calcul{
        @apply w-[270px] bg-white h-[490px] rounded-[10px];
    }
</style>