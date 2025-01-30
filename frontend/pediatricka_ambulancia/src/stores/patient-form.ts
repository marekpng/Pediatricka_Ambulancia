// store.js
import { defineStore } from 'pinia';


export const useStore = defineStore('app', {
    state: () => ({
        formData: {
            name: '',
            email: '',
            mobile: '',
            doctor: '',
            date: '',
            time: '',
            problemDescription: '',
        },
    }),
    getters: {
        getAllData: (state) => state.formData,
            // return state.formData;
        // }

    },
    actions: {
        // updateFormData(formData) {
        //     this.formData = formData;
        //
        // },
        // updateFormData({formData}: { formData: any }) {
        //     this.formData = formData;
        //
        // },
        updateFormData(newFormData) {
            this.formData = { ...this.formData, ...newFormData };
        }
    },


});