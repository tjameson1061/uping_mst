<template>
    <div>

        <!-- Form: Personal Info Form -->

        <b-col
                cols="12"
                class="mb-2"
        >
            <h3>
                Date Of Birth
            </h3>
            <small class="text-muted">
                Filter Settings
            </small>
        </b-col>


        <!-- Should be between -->
        <tab-content
                title="Account Details"
                icon="feather icon-file-text"
        >
            <b-row>
                <b-col
                        cols="6"
                        class="mb-2"
                >
                    <small class="text-muted">

                    </small>
                    <b-form-group
                            label="Should be less than"
                            label-for="i-username"
                    >
                        <b-form-input
                                id="shouldBeBetween1"
                                name="shouldBeBetween1"
                                placeholder="1000"
                                type="number"
                                v-model="filterData.object.shouldBeBetween1"
                        />
                    </b-form-group>
                </b-col>
                <b-col
                        cols="6"
                        class="mb-2"
                >
                    <small class="text-muted">

                    </small>
                    <b-form-group
                            label="Should be less than"
                            label-for="i-username"
                    >
                        <b-form-input
                                id="shouldBeBetween2"
                                name="shouldBeBetween2"
                                placeholder="1000"
                                type="number"
                                v-model="filterData.object.shouldBeBetween2"
                        />
                    </b-form-group>
                </b-col>
            </b-row>
        </tab-content>










    </div>
</template>

<script>
import { BRow, BCol, BForm, BFormGroup, BFormInput, BFormRadioGroup, BFormCheckboxGroup, BButton } from 'bootstrap-vue'
import flatPickr from 'vue-flatpickr-component'
import { ref } from '@vue/composition-api'
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
    },

  setup() {
    const filterData = ref({
        conditions: [],
    })


    const languageOptions = ['English', 'Spanish', 'French', 'Russian', 'German', 'Arabic', 'Sanskrit']

    const genderOptions = [
      { text: 'Male', value: 'male' },
      { text: 'Female', value: 'female' },
    ]

    const shouldContainOptions = [
        { text: 'EmployedFullTime', value: 'EmployedFullTime' },
        { text: 'EmployedPartTime', value: 'EmployedPartTime' },
        { text: 'EmployedTemporary', value: 'EmployedTemporary' },
        { text: 'SelfEmployed', value: 'SelfEmployed' },
    ]
    const shouldBeOptions =   [
        { text: 'EmployedFullTime', value: 'EmployedFullTime' },
        { text: 'EmployedPartTime', value: 'EmployedPartTime' },
        { text: 'EmployedTemporary', value: 'EmployedTemporary' },
        { text: 'SelfEmployed', value: 'SelfEmployed' },
        ]

    return {
        filterData,
      languageOptions,
      genderOptions,

        shouldContainOptions,
        shouldBeOptions,
    }
  },
}
</script>

<style lang="scss">
@import '~@core/scss/vue/libs/vue-flatpicker.scss';
</style>
