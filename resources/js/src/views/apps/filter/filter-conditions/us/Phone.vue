<template>
    <div>

        <!-- Form: Personal Info Form -->
        <b-col
            cols="12"
            class="mb-2"
        >
            <h3>
              Phone
            </h3>
            <small class="text-muted">
                Filter Settings
            </small>
        </b-col>

        <b-col
            cols="12"
            md="12"
            lg="12"
        >
            <b-form-group
                label="Should Not Match"
                label-for="contact-options"
                label-class="mb-1"
            >
                <b-form-checkbox-group
                    id="shouldNotMatch"
                    name="shouldNotMatch"
                    v-model="filterData.object.shouldNotMatch"
                    :options="phoneOptions"
                    :checked="filterData.object.shouldNotMatch"
                />
            </b-form-group>
        </b-col>


    </div>
</template>

<script>
    import { BRow, BCol, BForm, BFormGroup, BFormInput, BFormRadioGroup, BFormCheckboxGroup, BButton } from 'bootstrap-vue'
    import flatPickr from 'vue-flatpickr-component'
    import vSelect from 'vue-select'

    export default {
        components: {
            BRow,
            BCol,
            BForm,
            BFormGroup,
            flatPickr,
            BFormInput,
            vSelect,
            BFormRadioGroup,
            BFormCheckboxGroup,
            BButton,
        },
        props: {
            filterData: {
                type: Object,
                required: true,
            },
            phoneOptions: {
                type: Array,
                required: true,
            },
        },

        setup() {



            return {
                filterData,
                phoneOptions,
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-flatpicker.scss';
</style>
