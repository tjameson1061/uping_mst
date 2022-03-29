<template>
    <component :is="filterData === undefined ? 'div' : 'b-card'">

        <!-- Alert: No item found -->
        <b-alert
            variant="danger"
            :show="filterData === undefined"
        >
            <h4 class="alert-heading">
                Error fetching buyerFilter data
            </h4>
            <div class="alert-body">
                No buyerFilter found with this buyerFilter id. Check
                <b-link
                    class="alert-link"
                    :to="{ name: 'apps-filter-list'}"
                >
                    buyerFilter List
                </b-link>
                for other buyerFilters.
            </div>
        </b-alert>


        <b-tabs
            pills
        >

            <!-- Tab: Account -->
            <b-tab active>
                <template #title>
                    <feather-icon
                        icon="FilterIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Filter</span>
                </template>
                <filter-add-tab-account
                    :filter-data="filterData"
                    :select-options="selectOptions"
                    class="mt-2 pt-75"
                />
            </b-tab>

            <!-- Numeric Filters-->
            <b-tab v-if="filterData.filter_type == 'LoanAmount'">
                <template #title>
                    <feather-icon
                        icon="InfoIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Conditions</span>
                </template>
                <loan-amount
                    class="mt-2 pt-75"
                    :filter-data="filterData"
                />
            </b-tab>
            <b-tab v-else-if="filterData.filter_type == 'LoanTerms'">
                <template #title>
                    <feather-icon
                        icon="InfoIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Conditions</span>
                </template>
                <loan-terms
                    class="mt-2 pt-75"
                    :filter-data="filterData"
                />
            </b-tab>
            <b-tab v-else-if="filterData.filter_type == 'MonthlyCredit'">
                <template #title>
                    <feather-icon
                        icon="InfoIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Conditions</span>
                </template>
                <monthly-credit
                    class="mt-2 pt-75"
                    :filter-data="filterData"
                />
            </b-tab>
            <b-tab v-else-if="filterData.filter_type == 'MonthlyIncome'">
                <template #title>
                    <feather-icon
                        icon="InfoIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Conditions</span>
                </template>
                <monthly-income
                    class="mt-2 pt-75"
                    :filter-data="filterData"
                />
            </b-tab>
            <b-tab v-else-if="filterData.filter_type == 'MonthlyRent'">
                <template #title>
                    <feather-icon
                        icon="InfoIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Conditions</span>
                </template>
                <monthly-rent
                    class="mt-2 pt-75"
                    :filter-data="filterData"
                />
            </b-tab>

            <!--  Email Filter -->
            <b-tab v-else-if="filterData.filter_type == 'Email'">
                <template #title>
                    <feather-icon
                        icon="InfoIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Conditions</span>
                </template>
                <email-filter
                    class="mt-2 pt-75"
                    :filter-data="filterData"

                />
            </b-tab>

            <!--  Date Filter -->
            <b-tab v-else-if="filterData.filter_type == 'DateOfBirth'">
                <template #title>
                    <feather-icon
                            icon="InfoIcon"
                            size="16"
                            class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Conditions</span>
                </template>
                <date-of-birth
                        class="mt-2 pt-75"
                        :filter-data="filterData"
                />
            </b-tab>

            <!-- Multi Select Filters-->
            <b-tab v-else-if="filterData.filter_type == 'EmploymentStatus'">
                <template #title>
                    <feather-icon
                        icon="InfoIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Conditions</span>
                </template>
                <employment-status
                    class="mt-2 pt-75"
                    :filter-data="filterData"
                    :employment-options="employmentOptions"
                    title="Employment Status"
                />
            </b-tab>
            <b-tab v-else-if="filterData.filter_type == 'IncomeCycle'">
                <template #title>
                    <feather-icon
                        icon="InfoIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Conditions</span>
                </template>
                <income-cycle
                    class="mt-2 pt-75"
                    :filter-data="filterData"
                    :income-cycle-options="incomeCycleOptions"
                />
            </b-tab>
            <b-tab v-else-if="filterData.filter_type == 'MaritalStatus'">
                <template #title>
                    <feather-icon
                        icon="InfoIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Conditions</span>
                </template>
                <marital-status
                    class="mt-2 pt-75"
                    :filter-data="filterData"
                    :marital-status-options="maritalStatusOptions"
                />
            </b-tab>
            <b-tab v-else-if="filterData.filter_type == 'ResidentialStatus'">
                <template #title>
                    <feather-icon
                        icon="InfoIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Conditions</span>
                </template>
                <residential-status
                    class="mt-2 pt-75"
                    :filter-data="filterData"
                    :residential-status-options="residentialStatusOptions"
                />
            </b-tab>
            <b-tab v-else-if="filterData.filter_type == 'MonthsAtAddress'">
                <template #title>
                    <feather-icon
                        icon="InfoIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Conditions</span>
                </template>
                <months-at-address
                    class="mt-2 pt-75"
                    :filter-data="filterData"
                />
            </b-tab>
            <b-tab v-else-if="filterData.filter_type == 'InMilitary'">
                <template #title>
                    <feather-icon
                        icon="InfoIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Conditions</span>
                </template>
                <in-military
                    class="mt-2 pt-75"
                    :filter-data="filterData"
                    :in-military-options="inMilitaryOptions"
                />
            </b-tab>
            <b-tab v-else-if="filterData.filter_type == 'State'">
                <template #title>
                    <feather-icon
                        icon="InfoIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Conditions</span>
                </template>
                <state
                    class="mt-2 pt-75"
                    :filter-data="filterData"
                    :state-options="stateOptions"
                />
            </b-tab>
            <b-tab v-else-if="filterData.filter_type == 'BankAccountType'">
                <template #title>
                    <feather-icon
                        icon="InfoIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Conditions</span>
                </template>
                <bank-account-type
                    class="mt-2 pt-75"
                    :filter-data="filterData"
                    :bank-account-type-options="bankAccountTypeOptions"
                />
            </b-tab>
            <b-tab v-else-if="filterData.filter_type == 'Phone'">
                <template #title>
                    <feather-icon
                        icon="InfoIcon"
                        size="16"
                        class="mr-0 mr-sm-50"
                    />
                    <span class="d-none d-sm-inline">Conditions</span>
                </template>
                <phone
                    class="mt-2 pt-75"
                    :filter-data="filterData"
                    :phone-options="phoneOptions"

                />
            </b-tab>


            <!-- Date Filters-->
        </b-tabs>
    </component>
</template>

<script>
    import {
        BTab, BTabs, BCard, BAlert, BLink,
    } from 'bootstrap-vue'
    import { ref, onUnmounted } from '@vue/composition-api'
    import router from '@/router'
    import store from '@/store'
    import filterStoreModule from '../filterStoreModule'
    import FilterAddTabAccount from './FilterAddTabAccount.vue'
    import FilterAddTabInformation from './FilterAddTabInformation.vue'
    import LoanAmount from "../filter-conditions/uk/LoanAmount";
    import LoanTerms from "../filter-conditions/uk/LoanTerms";
    import EmailFilter from "../filter-conditions/uk/EmailFilter";
    import EmploymentStatus from "../filter-conditions/uk/EmploymentStatus";
    import MaritalStatus from "../filter-conditions/uk/MaritalStatus";
    import MonthlyCredit from "../filter-conditions/uk/MonthlyCredit";
    import MonthsAtAddress from "../filter-conditions/uk/MonthsAtAddress";
    import ResidentialStatus from "../filter-conditions/uk/ResidentialStatus";
    import MonthlyIncome from "../filter-conditions/uk/MonthlyIncome";
    import MonthlyRent from "../filter-conditions/uk/MonthlyRent";
    import IncomeCycle from "../filter-conditions/uk/IncomeCycle";
    import InMilitary from "../filter-conditions/us/InMilitary";
    import State from "../filter-conditions/us/State";
    import BankAccountType from "../filter-conditions/us/BankAccountType";
    import Phone from "../filter-conditions/us/Phone";
    import DateOfBirth from "../filter-conditions/us/DateOfBirth";
    import useFilterList from '../filter-list/useFilterList'

    import { useToast } from 'vue-toastification/composition'
    import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

    export default {
        components: {
            BTab,
            BTabs,
            BCard,
            BAlert,
            BLink,

            FilterAddTabAccount,
            FilterAddTabInformation,
            LoanAmount,
            LoanTerms,
            EmailFilter,
            EmploymentStatus,
            ResidentialStatus,
            MonthsAtAddress,
            MonthlyCredit,
            MonthlyIncome,
            MonthlyRent,
            MaritalStatus,
            IncomeCycle,
            InMilitary,
            State,
            Phone,
            DateOfBirth,
            BankAccountType,
            ToastificationContent,
        },

        setup() {
            const toast = useToast()
            const filterData = ref({
                filter_type: '',
                tier_id: '',
                buyer_id: '',
                conversion_type: '',
                object: {},
                conditions: {
                    shouldBeAnyOf: [],
                    shouldNotBeAnyOf: [],
                    shouldBeGreaterThan: [],
                    shouldBeLessThan: [],
                    shouldBeEqualTo: [],
                    shouldBeBetween1: [],
                    shouldBeBetween2: [],

                    shouldContain: '',
                    shouldEndWith: '',
                    shouldNotContain: '',
                    shouldNotEndWith: '',
                    shouldBe: '',

                    shouldNotMatch: [],
                },
                status: '',
            })

            const {
                employmentOptions,
                incomeCycleOptions,
                maritalStatusOptions,
                residentialStatusOptions,
                stateOptions,
                inMilitaryOptions,
                bankAccountTypeOptions,
                phoneOptions,
                goBack,

            } = useFilterList();


            const selectOptions = status => {
                if (status === 'pending') return 'warning'
                if (status === 'active') return 'success'
                if (status === 'inactive') return 'secondary'
                return 'primary'
            }


            const FILTERS = 'app-filters'

            // Register module
            if (!store.hasModule(FILTERS)) store.registerModule(FILTERS, filterStoreModule)

            // UnRegister on leave
            onUnmounted(() => {
                if (store.hasModule(FILTERS)) store.unregisterModule(FILTERS)
            })



            return {
                filterData,
                selectOptions,
                employmentOptions,
                incomeCycleOptions,
                maritalStatusOptions,
                residentialStatusOptions,
                stateOptions,
                inMilitaryOptions,
                bankAccountTypeOptions,
                phoneOptions,
                ToastificationContent,
                toast,
                goBack,
            }
        },
    }
</script>

<style>

</style>
