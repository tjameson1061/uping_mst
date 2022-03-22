<template>
    <b-sidebar
        id="add-new-advertiser-sidebar"
        :visible="isAddNewAdvertiserSidebarActive"
        bg-variant="white"
        sidebar-class="sidebar-lg"
        shadow
        backdrop
        no-header
        right
        @hidden="resetForm"
        @change="(val) => $emit('update:is-add-new-advertiser-sidebar-active', val)"
    >
        <template #default="{ hide }">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center content-sidebar-header px-2 py-1">
                <h5 class="mb-0">
                    Add New Advertiser
                </h5>

                <feather-icon
                    class="ml-1 cursor-pointer"
                    icon="XIcon"
                    size="16"
                    @click="hide"
                />

            </div>

            <!-- BODY -->
            <validation-observer
                #default="{ handleSubmit }"
                ref="refFormObserver"
            >
                <!-- Form -->
                <b-form
                    class="p-2"
                    @submit.prevent="handleSubmit(onSubmit)"
                    @reset.prevent="resetForm"
                >

                    <!--  advertiser_name -->
                    <validation-provider
                        #default="validationContext"
                        name="advertiser_name"
                        rules="required"
                    >
                        <b-form-group
                            label="Postback Name"
                            label-for="advertiser_name"
                        >
                            <b-form-input
                                id="advertiser_name"
                                v-model="advertiserData.advertiser_name"
                                autofocus
                                :state="getValidationState(validationContext)"
                                trim
                                placeholder="John Doe"
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!--  affiliatePostbackUrl -->
                    <validation-provider
                        #default="validationContext"
                        name="affiliatePostbackUrl"
                        rules="required"
                    >
                        <b-form-group
                            label="Postback URL"
                            label-for="affiliatePostbackUrl"
                        >
                            <b-form-input
                                id="affiliatePostbackUrl"
                                v-model="advertiserData.affiliatePostbackUrl"
                                autofocus
                                :state="getValidationState(validationContext)"
                                trim
                                placeholder="JohnDoe007"
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!-- Status -->
                    <validation-provider
                        #default="validationContext"
                        name="Global"
                        rules="required"
                    >
                        <b-form-group
                            label="Global"
                            label-for="global"
                            :state="getValidationState(validationContext)"
                        >
                            <v-select
                                v-model="advertiserData.global"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="globalOptions"
                                :clearable="false"
                                input-id="status"
                            />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>


                    <!-- user_id -->
                    <validation-provider
                        #default="validationContext"
                        name="User ID"
                        rules="required"
                    >
                        <b-form-group
                            label="User ID"
                            label-for="user_id"
                            :state="getValidationState(validationContext)"
                        >
                            <v-select
                                v-model="advertiserData.user_id"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="filterData.user_ids"
                                label="username"
                                :clearable="false"
                                input-id="user_id"
                            />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>




                    <!-- Form Actions -->
                    <div class="d-flex mt-2">
                        <b-button
                            v-ripple.400="'rgba(255, 255, 255, 0.15)'"
                            variant="primary"
                            class="mr-2"
                            type="submit"
                        >
                            Add
                        </b-button>
                        <b-button
                            v-ripple.400="'rgba(186, 191, 199, 0.15)'"
                            type="button"
                            variant="outline-secondary"
                            @click="hide"
                        >
                            Cancel
                        </b-button>
                    </div>

                </b-form>
            </validation-observer>
        </template>
    </b-sidebar>
</template>


<script>
    import {BSidebar, BForm, BFormGroup, BFormInput, BFormInvalidFeedback, BButton, BFormSelect} from 'bootstrap-vue'
    import { ValidationProvider, ValidationObserver } from 'vee-validate'
    import { required, alphaNum, email } from '@validations'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import { ref } from '@vue/composition-api'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import store from '@/store'


    export default {
        components: {
            BSidebar,
            BForm,
            BFormGroup,
            BFormInput,
            BFormInvalidFeedback,
            BButton,
            vSelect,
            BFormSelect,
            // Form Validation,
            ValidationProvider,
            ValidationObserver,
        },
        directives: {
            Ripple,
        },
        model: {
            prop: 'isAddAdvertiserSidebarActive',
            event: 'update:is-add-new-advertiser-sidebar-active',
        },
        props: {
            isAddNewAdvertiserSidebarActive: {
                type: Boolean,
                required: true,
            },
            statusOptions: {
                type: Array,
                required: true,
            },
            filterData: {
                type: Object,
                required: true,
            },
        },
        setup(props, { emit }) {
            const blankUserData = ref({
                tier_id: '',
                lead_type: '',
                status: '',
                partner_id: ''
            })

            const advertiserData = JSON.parse(JSON.stringify(blankUserData))
            const resetadvertiserData = () => {
                advertiserData.value = JSON.parse(JSON.stringify(blankUserData))
            }
            const onSubmit = () => {
                store.dispatch('app-advertisers/addAdvertiser',  advertiserData)
                    .then(() => {
                    emit('refetch-data')
                    emit('update:is-add-new-advertiser-sidebar-active', false)
                })
            }
            const globalOptions = [
                { label: 'Pending', value: 2 },
                { label: 'Active', value: 1 },
                { label: 'Inactive', value: 0 },
            ]


            // const { statusOptions, leadTypeOptions} = useMappingTierList()

            const { refFormObserver, getValidationState, resetForm } = formValidation(resetadvertiserData)



            return {
                advertiserData,
                // advertiserData,
                onSubmit,

                refFormObserver,
                getValidationState,
                resetForm,
                globalOptions
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';

    #add-new-advertiser-sidebar {
        .vs__dropdown-menu {
            max-height: 200px !important;
        }
    }
</style>
