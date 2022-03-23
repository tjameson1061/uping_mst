<template>
    <b-sidebar
        id="add-new-buyer-tier-sidebar"
        :visible="isAddNewBuyerTierSidebarActive"
        bg-variant="white"
        sidebar-class="sidebar-lg"
        shadow
        backdrop
        no-header
        right
        @hidden="resetForm"
        @change="(val) => $emit('update:is-add-new-buyer-tier-sidebar-active', val)"
    >
        <template #default="{ hide }">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center content-sidebar-header px-2 py-1">
                <h5 class="mb-0">
                    Add New Buyer Tier
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

                    <!--  Buyer Name -->
                    <validation-provider
                        #default="validationContext"
                        name="buyername"
                        rules="required"
                    >
                        <b-form-group
                            label="Name"
                            label-for="buyername"
                        >
                            <b-form-input
                                id="buyername"
                                v-model="buyerTierData.buyername"
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

                    <!-- Lead Type -->
                    <validation-provider
                        #default="validationContext"
                        name="Lead Type"
                        rules="required"
                    >
                        <b-form-group
                            label="Lead Type"
                            label-for="lead_type"
                            :state="getValidationState(validationContext)"
                        >
                            <v-select
                                v-model="buyerTierData.lead_type"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="leadTypeOptions"
                                :clearable="false"
                                input-id="lead_type"
                            />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>



                    <!-- Buyer ID -->

                        <b-form-group
                            label="Buyer ID"
                            label-for="buyer_id"
                        >
                            <v-select
                                v-model="buyerTierData.buyer_id"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="filterTierData.filterTierData.buyer_ids"
                                label="name"
                                :clearable="false"
                                input-id="buyer_id"
                            />
                        </b-form-group>

                    <!--  tier_price -->
                    <validation-provider
                        #default="validationContext"
                        name="tier_price"
                        rules="required"
                    >
                        <b-form-group
                            label="Tier Price"
                            label-for="tier_price"
                        >
                            <b-form-input
                                id="tier_price"
                                v-model="buyerTierData.tier_price"
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

                    <!-- Model Type -->
                    <validation-provider
                        #default="validationContext"
                        name="Model Type"
                        rules="required"
                    >
                        <b-form-group
                            label="Model Type"
                            label-for="model_type"
                            :state="getValidationState(validationContext)"
                        >
                            <v-select
                                v-model="buyerTierData.model_type"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="modelTypeOptions"
                                :clearable="false"
                                input-id="model_type"
                            />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!--  posting_order -->
                    <validation-provider
                        #default="validationContext"
                        name="posting_order"
                        rules="required"
                    >
                        <b-form-group
                            label="Posting Order"
                            label-for="posting_order"
                        >
                            <b-form-input
                                id="posting_order"
                                v-model="buyerTierData.posting_order"
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

                    <!--  parameter1 -->
                    <validation-provider
                        #default="validationContext"
                        name="parameter1"
                        rules="required"
                    >
                        <b-form-group
                            label="Parameter 1"
                            label-for="parameter1"
                        >
                            <b-form-input
                                id="parameter1"
                                v-model="buyerTierData.parameter1"
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

                    <!--  parameter2 -->
                    <validation-provider
                        #default="validationContext"
                        name="parameter2"
                        rules="required"
                    >
                        <b-form-group
                            label="Parameter 2"
                            label-for="parameter2"
                        >
                            <b-form-input
                                id="parameter2"
                                v-model="buyerTierData.parameter2"
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

                    <!--  parameter3 -->
                    <validation-provider
                        #default="validationContext"
                        name="parameter3"
                        rules="required"
                    >
                        <b-form-group
                            label="Parameter 3"
                            label-for="parameter3"
                        >
                            <b-form-input
                                id="parameter3"
                                v-model="buyerTierData.parameter3"
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

                    <!--  ping_url_test -->
                    <validation-provider
                        #default="validationContext"
                        name="ping_url_test"
                        rules="required"
                    >
                        <b-form-group
                            label="Ping URL Test"
                            label-for="ping_url_test"
                        >
                            <b-form-input
                                id="ping_url_test"
                                v-model="buyerTierData.ping_url_test"
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

                    <!--  post_url_test -->
                    <validation-provider
                        #default="validationContext"
                        name="post_url_test"
                        rules="required"
                    >
                        <b-form-group
                            label="Post Url Test"
                            label-for="post_url_test"
                        >
                            <b-form-input
                                id="post_url_test"
                                v-model="buyerTierData.post_url_test"
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

                    <!--  ping_url_live -->
                    <validation-provider
                        #default="validationContext"
                        name="ping_url_live"
                        rules="required"
                    >
                        <b-form-group
                            label="Ping Test Live"
                            label-for="ping_url_live"
                        >
                            <b-form-input
                                id="ping_url_live"
                                v-model="buyerTierData.ping_url_live"
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

                    <!--  post_url_live -->
                    <validation-provider
                        #default="validationContext"
                        name="post_url_live"
                        rules="required"
                    >
                        <b-form-group
                            label="Ping Url Live"
                            label-for="post_url_live"
                        >
                            <b-form-input
                                id="post_url_live"
                                v-model="buyerTierData.post_url_live"
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

                    <!--  timeout -->
                    <validation-provider
                        #default="validationContext"
                        name="timeout"
                        rules="required"
                    >
                        <b-form-group
                            label="Timeout"
                            label-for="timeout"
                        >
                            <b-form-input
                                id="timeout"
                                v-model="buyerTierData.timeout"
                                autofocus
                                :state="getValidationState(validationContext)"
                                trim
                                placeholder="120"
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!--  timeout -->
                    <validation-provider
                            #default="validationContext"
                            name="buyer_tier_id"
                            rules="required"
                    >
                        <b-form-group
                                label="Buyer Tier ID"
                                label-for="buyer_tier_id"
                        >
                            <b-form-input
                                    id="buyer_tier_id"
                                    v-model="buyerTierData.buyer_tier_id"
                                    autofocus
                                    :state="getValidationState(validationContext)"
                                    trim
                                    placeholder="120"
                            />

                            <b-form-invalid-feedback>
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!-- Status -->
                    <validation-provider
                        #default="validationContext"
                        name="Status"
                        rules="required"
                    >
                        <b-form-group
                            label="Status"
                            label-for="status"
                            :state="getValidationState(validationContext)"
                        >
                            <v-select
                                v-model="buyerTierData.status"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="statusOptions"
                                :clearable="false"
                                input-id="status"
                            />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!-- Mode -->
                    <validation-provider
                        #default="validationContext"
                        name="Mode"
                        rules="required"
                    >
                        <b-form-group
                            label="Mode"
                            label-for="mode"
                            :state="getValidationState(validationContext)"
                        >
                            <v-select
                                v-model="buyerTierData.mode"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="modeOptions"
                                :clearable="false"
                                input-id="mode"
                            />
                            <b-form-invalid-feedback :state="getValidationState(validationContext)">
                                {{ validationContext.errors[0] }}
                            </b-form-invalid-feedback>
                        </b-form-group>
                    </validation-provider>

                    <!-- Rotate-->
                    <validation-provider
                        #default="validationContext"
                        name="Rotate"
                        rules="required"
                    >
                        <b-form-group
                            label="Rotate"
                            label-for="rotate"
                            :state="getValidationState(validationContext)"
                        >
                            <v-select
                                v-model="buyerTierData.rotate"
                                :dir="$store.state.appConfig.isRTL ? 'rtl' : 'ltr'"
                                :options="rotateOptions"
                                :clearable="false"
                                input-id="rotate"
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
    import { BSidebar, BForm, BFormGroup, BFormInput, BFormInvalidFeedback, BButton } from 'bootstrap-vue'
    import { ValidationProvider, ValidationObserver } from 'vee-validate'
    import {onUnmounted, ref} from '@vue/composition-api'
    import { required, alphaNum, email } from '@validations'
    import formValidation from '@core/comp-functions/forms/form-validation'
    import Ripple from 'vue-ripple-directive'
    import vSelect from 'vue-select'
    import countries from '@/@fake-db/data/other/countries'
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

            // Form Validation
            ValidationProvider,
            ValidationObserver,
        },
        directives: {
            Ripple,
        },
        model: {
            prop: 'isAddNewBuyerTierSidebarActive',
            event: 'update:is-add-new-buyer-tier-sidebar-active',
        },
        props: {
            isAddNewBuyerTierSidebarActive: {
                type: Boolean,
                required: true,
            },
            filterTierData: {
                type: Object,
                required: true,
            },
            statusOptions: {
                type: Array,
                required: true,
            },
            leadTypeOptions: {
                type: Array,
                required: true,
            },
            modelTypeOptions: {
                type: Array,
                required: true,
            },
            modeOptions: {
                type: Array,
                required: true,
            },

        },
        data() {
            return {
                required,
                alphaNum,
                email,
                countries,
            }
        },

        setup(props, { emit }) {

            const blankBuyerTierData = {
                buyername: '',
                buyer_id: '',
                tier_price: '',

                parameter1: '',
                parameter2: '',
                parameter3: '',
                ping_url_live: '',
                ping_url_test: '',
                post_url_test: '',
                post_url_live: '',
                posting_order: '',


                buyer_tier_id: '',
                lead_type: '',
                rotate: '',
                model_type: '',
                mode: '',
                status: '',

            }

            const buyerTierData = ref(JSON.parse(JSON.stringify(blankBuyerTierData)))
            const resetbuyerTierData = () => {
                buyerTierData.value = JSON.parse(JSON.stringify(blankBuyerTierData))
            }
            const onSubmit = () => {
                store.dispatch('app-buyer-tier/addTier', buyerTierData.value).then(() => {
                    emit('refetch-data')
                    emit('update:is-add-new-buyer-tier-sidebar-active', false)
                })
            }


            const rotateOptions = [
                { label: 'CPA', value: 1 },
                { label: 'CPL', value: 2 },
            ]



            const { refFormObserver, getValidationState, resetForm } = formValidation(resetbuyerTierData)

            return {
                buyerTierData,
                onSubmit,

                refFormObserver,
                getValidationState,
                resetForm,

                // Options
                rotateOptions,
            }
        },
    }
</script>

<style lang="scss">
    @import '~@core/scss/vue/libs/vue-select.scss';

    #add-new-buyer-tier-sidebar {
        .vs__dropdown-menu {
            max-height: 200px !important;
        }
    }
</style>
